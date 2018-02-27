<?php

declare(strict_types=1);

namespace Blockchain\Miner;

interface HashDifficulty
{
    public function hashMatchesDifficulty(string $hash, int $difficulty): bool;
}
