<?php

declare(strict_types=1);

namespace Blockchain;

use Blockchain\Miner\HashDifficulty;
use DateTimeImmutable;

final class Miner
{
    /**
     * @var Blockchain
     */
    private $blockchain;

    /**
     * @var HashDifficulty
     */
    private $hashDifficulty;

    public function __construct(Blockchain $blockchain, HashDifficulty $hashDifficulty)
    {
        $this->blockchain = $blockchain;
        $this->hashDifficulty = $hashDifficulty;
    }

    public function mineBlock(string $data): Block
    {
        $nonce = 0;
        $lastBlock = $this->blockchain->last();
        $difficulty = $lastBlock->difficulty();
        $index = $lastBlock->index() + 1;
        $previousHash = $lastBlock->hash();
        $createdAt = new DateTimeImmutable();

        while (true) {
            $hash = Block::calculateHash($index, $previousHash, $createdAt, $data, $difficulty, $nonce);
            if ($this->hashDifficulty->hashMatchesDifficulty($hash, $difficulty)) {
                $block = new Block($index, $hash, $previousHash, $createdAt, $data, $difficulty, $nonce);
                $this->blockchain->add($block);

                return $block;
            }

            ++$nonce;
        }
    }

    public function blockchain(): Blockchain
    {
        return $this->blockchain;
    }

    public function replaceBlockchain(Blockchain $blockchain): void
    {
        if (! $blockchain->isValid()) {
            return;
        }

        $this->blockchain = $blockchain;
    }
}
