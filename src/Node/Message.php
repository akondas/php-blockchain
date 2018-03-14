<?php

declare(strict_types=1);

namespace Blockchain\Node;

final class Message
{
    public const REQUEST_LATEST = 'request-latest';

    public const REQUEST_ALL = 'request-all';

    public const BLOCKCHAIN = 'blockchain';

    /**
     * @var string
     */
    private $type;

    /**
     * @var ?string
     */
    private $data;

    public function __construct(string $type, ?string $data = null)
    {
        $this->type = $type;
        $this->data = $data;
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
