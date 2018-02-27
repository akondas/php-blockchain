<?php

declare(strict_types=1);

namespace Blockchain\Miner\HashDifficulty;

use Blockchain\Miner\HashDifficulty;

final class ZeroPrefix implements HashDifficulty
{
    public function hashMatchesDifficulty(string $hash, int $difficulty): bool
    {
        if ($difficulty === 0) {
            return true;
        }

        $binary = $this->binaryString($hash, $difficulty);
        $prefix = str_repeat('0', $difficulty);

        return strpos($binary, $prefix) === 0;
    }

    private function binaryString(string $hash, int $difficulty): string
    {
        $binary = '';
        $lookup = [
            '0' => '0000',
            '1' => '0001',
            '2' => '0010',
            '3' => '0011',
            '4' => '0100',
            '5' => '0101',
            '6' => '0110',
            '7' => '0111',
            '8' => '1000',
            '9' => '1001',
            'a' => '1010',
            'b' => '1011',
            'c' => '1100',
            'd' => '1101',
            'e' => '1110',
            'f' => '1111',
        ];
        $length = ceil($difficulty / 4);

        for ($i = 0; $i < $length; ++$i) {
            $binary .= $lookup[$hash[$i]];
        }

        return $binary;
    }
}
