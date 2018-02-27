<?php

declare(strict_types=1);

namespace Blockchain;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class BlockTest extends TestCase
{
    public function testNextBlockValidation(): void
    {
        $block = new Block(
            1,
            'c44ac539b4dd64756ccc170e729eb645737f8956d64c8759d76309566318e398',
            '8b31c9ec8c2df21968aca3edd2bda8fc77ed45b0b3bc8bc39fa27d5c795bc829',
            new DateTimeImmutable('2018-02-27 22:03:09'),
            'php-blockchain best lib for blockchain in PHP',
            0,
            0
        );
        $nextBlock = new Block(
            2,
            'f25240f48733ce862cfffc11ec1ae257b86dd180b70476381534bfcada64e625',
            'c44ac539b4dd64756ccc170e729eb645737f8956d64c8759d76309566318e398',
            new DateTimeImmutable('2018-02-27 22:03:09'),
            'php-ml best lib for machine learning in PHP',
            0,
            0
        );

        self::assertTrue($block->isNextValid($nextBlock));
    }

    public function testNextBlockIndexValidation(): void
    {
        $block = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data', 0, 0);
        $nextBlock = new Block(55, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data', 0, 0);

        self::assertFalse($block->isNextValid($nextBlock));
    }

    public function testNextBlockPreviousHashValidation(): void
    {
        $block = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data', 0, 0);
        $nextBlock = new Block(2, 'other-hash', 'other-prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data', 0, 0);

        self::assertFalse($block->isNextValid($nextBlock));
    }

    public function testNextBlockHashCalculationValidation(): void
    {
        $block = new Block(
            1,
            'c44ac539b4dd64756ccc170e729eb645737f8956d64c8759d76309566318e398',
            '8b31c9ec8c2df21968aca3edd2bda8fc77ed45b0b3bc8bc39fa27d5c795bc829',
            new DateTimeImmutable('2018-02-27 22:03:09'),
            'php-blockchain best lib for blockchain in PHP',
            0,
            0
        );
        $nextBlock = new Block(
            2,
            'some-invalid-f25240f48733ce862cfffc11ec1ae257b86dd180b70476381534bfcada64e625',
            'c44ac539b4dd64756ccc170e729eb645737f8956d64c8759d76309566318e398',
            new DateTimeImmutable('2018-02-27 22:03:09'),
            'php-ml best lib for machine learning in PHP',
            0,
            0
        );

        self::assertFalse($block->isNextValid($nextBlock));
    }

    public function testBlockIsEqual(): void
    {
        $block = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data', 0, 0);
        $sameBlock = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data', 0, 0);

        self::assertTrue($block->isEqual($sameBlock));
    }

    public function testBlockIsNotEqual(): void
    {
        $block = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data', 0, 0);
        $otherBlock = new Block(1, 'hash', 'prev-hash', new DateTimeImmutable('2018-01-01 00:00:00'), 'some financial data!', 0, 0);

        self::assertFalse($block->isEqual($otherBlock));
    }
}
