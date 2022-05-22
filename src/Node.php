<?php

declare(strict_types=1);

namespace Blockchain;

use Blockchain\Node\Message;
use Blockchain\Node\P2pServer;
use Blockchain\Node\Peer;

final class Node
{
    public function __construct(private Miner $miner, private P2pServer $p2pServer)
    {
    }

    /**
     * @return Block[]
     */
    public function blocks(): array
    {
        return $this->miner->blockchain()->blocks();
    }

    public function mineBlock(string $data): Block
    {
        $block = $this->miner->mineBlock($data);
        $this->p2pServer->broadcast(new Message(Message::BLOCKCHAIN, \serialize($this->blockchain()->withLastBlockOnly())));

        return $block;
    }

    /**
     * @return Peer[]
     */
    public function peers(): array
    {
        return $this->p2pServer->peers();
    }

    public function connect(string $host, int $port): void
    {
        $this->p2pServer->connect($host, $port);
    }

    public function blockchain(): Blockchain
    {
        return $this->miner->blockchain();
    }

    public function replaceBlockchain(Blockchain $blockchain): void
    {
        $this->miner->replaceBlockchain($blockchain);
    }
}
