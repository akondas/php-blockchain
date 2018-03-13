<?php

declare(strict_types=1);

namespace Blockchain;

use Blockchain\Node\Message;
use Blockchain\Node\Peer;
use Blockchain\Node\Peers;

final class Node
{
    /**
     * @var Peers
     */
    private $peers;

    /**
     * @var Miner
     */
    private $miner;

    public function __construct(Miner $miner)
    {
        $this->miner = $miner;
        $this->peers = new Peers();
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
        $this->peers->broadcast(new Message(Message::TYPE_LAST_BLOCK, json_encode($block)));

        return $block;
    }

    /**
     * @return Peer[]
     */
    public function peers(): array
    {
        return $this->peers->all();
    }

    public function addPeer(Peer $peer): void
    {
        if ($this->peers->contains($peer)) {
            return;
        }

        $this->peers->add($peer);
    }
}
