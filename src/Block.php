<?php

declare(strict_types=1);

namespace Blockchain;

use DateTimeImmutable;
use JsonSerializable;

final class Block implements JsonSerializable
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

    /**
     * @var int
     */
    private $difficulty;

    /**
     * @var int
     */
    private $nonce;

    public function __construct(
        int $index,
        string $hash,
        string $previousHash,
        DateTimeImmutable $createdAt,
        string $data,
        int $difficulty,
        int $nonce
    ) {
        $this->index = $index;
        $this->hash = $hash;
        $this->previousHash = $previousHash;
        $this->createdAt = $createdAt;
        $this->data = $data;
        $this->difficulty = $difficulty;
        $this->nonce = $nonce;
    }

    public static function genesis(): self
    {
        return new self(0, '8b31c9ec8c2df21968aca3edd2bda8fc77ed45b0b3bc8bc39fa27d5c795bc829', '', new DateTimeImmutable('2018-02-23 23:59:59'), 'PHP is awesome!', 0, 0);
    }

    public function isNextValid(self $block): bool
    {
        if ($block->index !== $this->index + 1) {
            return false;
        }

        if ($block->previousHash !== $this->hash) {
            return false;
        }

        if ($block->hash !== self::calculateHash($block->index, $block->previousHash, $block->createdAt, $block->data, $block->difficulty, $block->nonce)) {
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
            && $this->data === $block->data
            && $this->difficulty === $block->difficulty
            && $this->nonce === $block->nonce
        ;
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function previousHash(): string
    {
        return $this->previousHash;
    }

    public function difficulty(): int
    {
        return $this->difficulty;
    }

    public function index(): int
    {
        return $this->index;
    }

    public function data(): string
    {
        return $this->data;
    }

    public static function calculateHash(
        int $index,
        string $previousHash,
        DateTimeImmutable $createdAt,
        string $data,
        int $difficulty,
        int $nonce
    ): string {
        return hash(self::HASH_ALGORITHM, $index.$previousHash.$createdAt->getTimestamp().$data.$difficulty.$nonce);
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return [
            'index' => $this->index,
            'hash' => $this->hash,
            'previousHash' => $this->previousHash,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'data' => $this->data,
            'difficulty' => $this->difficulty,
            'nonce' => $this->nonce,
        ];
    }
}
