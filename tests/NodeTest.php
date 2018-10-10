<?php

declare(strict_types=1);

namespace Blockchain;

use Blockchain\Miner\HashDifficulty\ZeroPrefix;
use Blockchain\Node\P2pServer;
use PHPUnit\Framework\TestCase;

final class NodeTest extends TestCase
{
    /**
     * @var Node
     */
    private $node;

    public function setUp(): void
    {
        /** @var P2pServer $p2pServer */
        $p2pServer = $this->createMock(P2pServer::class);
        $this->node = new Node(
            new Miner(new Blockchain(Block::genesis()), new ZeroPrefix()),
            $p2pServer
        );
    }

    public function testListBlock(): void
    {
        $blocks = $this->node->blocks();
        self::assertCount(1, $blocks);
        self::assertInstanceOf(Block::class, $blocks[0]);
    }

    public function testMineBlock(): void
    {
        $block = $this->node->mineBlock('PHP is awesome');

        self::assertInstanceOf(Block::class, $block);
        self::assertEquals(1, $block->index());
        self::assertEquals('PHP is awesome', $block->data());
    }
}
