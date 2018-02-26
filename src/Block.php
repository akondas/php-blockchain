<?php

declare(strict_types=1);

namespace Blockchain;

use DateTimeImmutable;

final class Block
{
    public const HASH_ALGORITHM = 'sha256';

    /**
     * @var int
     */
    private $index;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var string
     */
    private $previousHash;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @var string
     */
    private $data;

    public function __construct(int $index, string $hash, string $previousHash, DateTimeImmutable $createdAt, string $data)
    {
        $this->index = $index;
        $this->hash = $hash;
        $this->previousHash = $previousHash;
        $this->createdAt = $createdAt;
        $this->data = $data;
    }

    public static function genesis(): self
    {
        return new self(0, '44f669382364d526982eb06973688597499f1b22b19b4e5145a5fa0fd4fead60', '', new DateTimeImmutable('2018-02-23 23:59:59'), 'PHP is awesome!');
    }

    public function isNextValid(self $block): bool
    {
        if ($block->index !== $this->index + 1) {
            return false;
        }

        if ($block->previousHash !== $this->hash) {
            return false;
        }

        if ($block->hash !== $this->calculateHash($block->index, $block->previousHash, $block->createdAt, $block->data)) {
            return false;
        }

        return true;
    }

    public function isEqual(self $block): bool
    {
        return $this->index === $block->index
            && $this->hash === $block->hash
            && $this->previousHash === $block->previousHash
            && $this->createdAt->getTimestamp() === $block->createdAt->getTimestamp()
            && $this->data === $block->data;
    }

    public function hash(): string
    {
        return $this->hash;
    }

    private function calculateHash(int $number, string $previousHash, DateTimeImmutable $createdAt, string $data): string
    {
        return hash(self::HASH_ALGORITHM, $number.$previousHash.$createdAt->getTimestamp().$data);
    }
}
