<?php

declare(strict_types=1);

namespace Blockchain\Node;

use JsonSerializable;

final class Peer implements JsonSerializable
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function host(): string
    {
        return $this->host;
    }

    public function port(): int
    {
        return $this->port;
    }

    public function isEqual(self $peer): bool
    {
        $this->host === $peer->host && $this->port === $peer->port;
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return [
            'host' => $this->host,
            'port' => $this->port,
        ];
    }
}
