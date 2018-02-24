<?php

declare(strict_types=1);

namespace Blockchain;

final class Blockchain
{
    /**
     * @var Block[]
     */
    private $blocks = [];

    public function __construct(Block $genesisBlock)
    {
        $this->blocks[] = $genesisBlock;
    }

    public function add(Block $block): void
    {
        $this->blocks[] = $block;
    }

    public function isValid(): bool
    {
        if (! $this->blocks[0]->isEqual(Block::genesis())) {
            return false;
        }

        $count = count($this->blocks) - 1;
        for ($i = 0; $i < $count; ++$i) {
            if (! $this->blocks[$i]->isNextValid($this->blocks[$i + 1])) {
                return false;
            }
        }

        return true;
    }
}
