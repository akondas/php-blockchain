<?php

declare(strict_types=1);

namespace Blockchain;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class BlockTest extends TestCase
{
    public function testNextBlockValidation(): void
    {
        $block = new Block(1, 'c666e1a82b8627690120cc43dbe79e9ec94ba5c3f6207d7c2f53cfa03e9db0b9', '44f669382364d526982eb06973688597499f1b22b19b4e5145a5fa0fd4fead60', new DateTimeImmutable('2018-02-24 01:00:00'), 'php-ml best lib for machine learning in PHP');
        $nextBlock = new Block(2, '87ce6a4efd23ce946ca907236e2d11b499a9e4bf3e607f9404e190c21be18a9f', 'c666e1a82b8627690120cc43dbe79e9ec94ba5c3f6207d7c2f53cfa03e9db0b9', new DateTimeImmutable('2018-02-24 01:00:00'), 'php-blockchain best lib for blockchain in PHP');

        self::assertTrue($block->isNextValid($nextBlock));
    }

    public function testNextBlockIndexValidation(): void
    {
        $block = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data');
        $nextBlock = new Block(55, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data');

        self::assertFalse($block->isNextValid($nextBlock));
    }

    public function testNextBlockPreviousHashValidation(): void
    {
        $block = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data');
        $nextBlock = new Block(2, 'other-hash', 'other-prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data');

        self::assertFalse($block->isNextValid($nextBlock));
    }

    public function testNextBlockHashCalculationValidation(): void
    {
        $block = new Block(1, 'c666e1a82b8627690120cc43dbe79e9ec94ba5c3f6207d7c2f53cfa03e9db0b9', '44f669382364d526982eb06973688597499f1b22b19b4e5145a5fa0fd4fead60', new DateTimeImmutable('2018-02-24 01:00:00'), 'php-ml best lib for machine learning in PHP');
        $nextBlock = new Block(2, '07ce6a4efd23ce946ca907236e2d11b499a9e4bf3e607f9404e190c21be18a9f', 'c666e1a82b8627690120cc43dbe79e9ec94ba5c3f6207d7c2f53cfa03e9db0b9', new DateTimeImmutable('2018-02-24 01:00:00'), 'php-blockchain best lib for blockchain in PHP');

        self::assertFalse($block->isNextValid($nextBlock));
    }

    public function testBlockIsEqual(): void
    {
        $block = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data');
        $sameBlock = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data');

        self::assertTrue($block->isEqual($sameBlock));
    }

    public function testBlockIsNotEqual(): void
    {
        $block = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data');
        $otherBlock = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data!');

        self::assertFalse($block->isEqual($otherBlock));
    }
}
