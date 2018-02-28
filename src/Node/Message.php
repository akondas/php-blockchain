<?php

declare(strict_types=1);

namespace Blockchain\Node;

final class Message
{
    public const TYPE_LAST_BLOCK = 'last-block';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $data;

    public function __construct(string $type, string $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function data(): string
    {
        return $this->data;
    }
}
