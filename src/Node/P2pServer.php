<?php

declare(strict_types=1);

namespace Blockchain\Node;

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
        $peer = new Peer($connection);
        if ($this->contains($peer)) {
            return;
        }

        //$connection->on('data')
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
    }

    /**
     * @return Peer[]
     */
    public function peers(): array
    {
        return $this->peers;
    }

    private function contains(Peer $peer): bool
    {
        foreach ($this->peers as $p) {
            if ($p->isEqual($peer)) {
                return true;
            }
        }

        return false;
    }
}
