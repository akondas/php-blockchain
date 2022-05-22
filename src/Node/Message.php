<?php

declare(strict_types=1);

namespace Blockchain\Node;

final class Message
{
    public const REQUEST_LATEST = 'request-latest';

    public const REQUEST_ALL = 'request-all';

    public const BLOCKCHAIN = 'blockchain';

    public function __construct(
        private string $type,
        private ?string $data = null
    ) {
    }

    public function type(): string
    {
        return $this->type;
    }

    public function data(): ?string
    {
        return $this->data;
    }
}
