<?php

declare(strict_types=1);

namespace Blockchain\Node;

use RuntimeException;

final class Peers
{
    /**
     * @var Peer[]
     */
    private $peers = [];

    /**
     * @return Peer[]
     */
    public function all(): array
    {
        return $this->peers;
    }

    public function contains(Peer $peer): bool
    {
        foreach ($this->peers as $p) {
            if ($p->isEqual($peer)) {
                return true;
            }
        }

        return false;
    }

    public function add(Peer $peer): void
    {
        if ($this->contains($peer)) {
            throw new RuntimeException(sprintf('Peer %s:%s already exist', $peer->host(), $peer->port()));
        }

        $this->peers[] = $peer;
    }

    public function broadcast(Message $message): void
    {
    }
}
