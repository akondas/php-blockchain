<?php

declare(strict_types=1);

namespace Blockchain\Node;

use JsonSerializable;
use React\Socket\ConnectionInterface;

final class Peer implements JsonSerializable
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function send(Message $message): void
    {
        $this->connection->write(serialize($message));
    }

    public function host(): string
    {
        return parse_url((string) $this->connection->getRemoteAddress(), PHP_URL_HOST);
    }

    public function port(): int
    {
        return parse_url((string) $this->connection->getRemoteAddress(), PHP_URL_PORT);
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
