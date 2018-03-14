<?php

declare(strict_types=1);

namespace Blockchain\Node;

use Blockchain\Blockchain;
use Blockchain\Node;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;
use RuntimeException;

class P2pServer
{
    /**
     * @var Node
     */
    private $node;

    /**
     * @var Connector
     */
    private $connector;

    /**
     * @var Peer[]
     */
    private $peers = [];

    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function __invoke(ConnectionInterface $connection): void
    {
        if (isset($this->peers[$connection->getRemoteAddress()])) {
            return;
        }

        $connection->on('data', function (string $data) use ($connection): void {
            $message = unserialize($data, [Message::class]);
            switch ($message->type()) {
                case Message::REQUEST_LATEST:
                    $connection->write(serialize(new Message(
                        Message::BLOCKCHAIN,
                        serialize($this->node->blockchain()->withLastBlockOnly())
                    )));

                    break;
                case Message::REQUEST_ALL:
                    $connection->write(serialize(new Message(
                        Message::BLOCKCHAIN,
                        serialize($this->node->blockchain())
                    )));

                    break;
                case Message::BLOCKCHAIN:
                    $this->handleBlockchain(unserialize($message->data(), [Blockchain::class]), $connection);

                    break;
            }
        });

        $connection->on('close', function () use ($connection): void {
            unset($this->peers[$connection->getRemoteAddress()]);
        });

        $this->peers[$connection->getRemoteAddress()] = new Peer($connection);
        $this->peers[$connection->getRemoteAddress()]->send(new Message(Message::REQUEST_LATEST));
    }

    public function attachNode(Node $node): void
    {
        if ($this->node !== null) {
            throw new RuntimeException('Node already attached to p2pServer');
        }

        $this->node = $node;
    }

    public function connect(string $host, int $port): void
    {
        $this->connector->connect(sprintf('%s:%s', $host, $port))->then(function (ConnectionInterface $connection): void {
            $this($connection);
        });
    }

    public function broadcast(Message $message): void
    {
        foreach ($this->peers as $peer) {
            $peer->send($message);
        }
    }

    /**
     * @return Peer[]
     */
    public function peers(): array
    {
        return array_values($this->peers);
    }

    private function handleBlockchain(Blockchain $blockchain, ConnectionInterface $connection): void
    {
        if ($blockchain->size() === 0) {
            return;
        }

        if ($blockchain->last()->index() <= $this->node->blockchain()->last()->index()) {
            return; // received blockchain is no longer than current blockchain, skip
        }

        if ($blockchain->last()->previousHash() === $this->node->blockchain()->last()->hash()) {
            $this->node->blockchain()->add($blockchain->last());
        } elseif ($blockchain->size() === 1) {
            $connection->write(serialize(new Message(Message::REQUEST_ALL)));
        } else {
            $this->node->replaceBlockchain($blockchain);
        }
    }
}
