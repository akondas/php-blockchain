<?php

declare(strict_types=1);

namespace Blockchain\Node;

use JsonSerializable;
use React\Socket\ConnectionInterface;

final class Peer implements JsonSerializable
{
    public function __construct(private ConnectionInterface $connection)
    {
    }

    public function send(Message $message): void
    {
        $this->connection->write(serialize($message));
    }

    public function host(): string
    {
        return (string) parse_url((string) $this->connection->getRemoteAddress(), PHP_URL_HOST);
    }

    public function port(): int
    {
        return (int) parse_url((string) $this->connection->getRemoteAddress(), PHP_URL_PORT);
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return [
            'host' => $this->host(),
            'port' => $this->port(),
        ];
    }
}
