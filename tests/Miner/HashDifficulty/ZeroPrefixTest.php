<?php

declare(strict_types=1);

namespace Blockchain\Miner\HashDifficulty;

use PHPUnit\Framework\TestCase;

final class ZeroPrefixTest extends TestCase
{
    /**
     * @dataProvider zeroPrefixDifficultyProvider
     */
    public function testHashMatchesDifficulty(string $hash, int $difficulty, bool $match): void
    {
        $hashDifficulty = new ZeroPrefix();

        self::assertEquals($match, $hashDifficulty->hashMatchesDifficulty($hash, $difficulty));
    }

    /**
     * @return mixed[]
     */
    public function zeroPrefixDifficultyProvider(): array
    {
        return [
            ['1234', 0, true],
            ['08f3', 4, true],
            ['14ac', 4, false],
            ['0028', 8, true],
            ['05c3', 8, false],
            ['000094', 16, true],
            ['0007ac', 16, false],
        ];
    }
}
