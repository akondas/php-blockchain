<?php

declare(strict_types=1);

namespace Blockchain;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

final class BlockchainTest extends TestCase
{
    public function testNewBlockchainValidation(): void
    {
        $chain = new Blockchain(Block::genesis());

        self::assertTrue($chain->isValid());
    }

    public function testBlockchainValidation(): void
    {
        $chain = new Blockchain(Block::genesis());
        $chain->add(new Block(1, 'c666e1a82b8627690120cc43dbe79e9ec94ba5c3f6207d7c2f53cfa03e9db0b9', '44f669382364d526982eb06973688597499f1b22b19b4e5145a5fa0fd4fead60', new DateTimeImmutable('2018-02-24 01:00:00'), 'php-ml best lib for machine learning in PHP'));
        $chain->add(new Block(2, '87ce6a4efd23ce946ca907236e2d11b499a9e4bf3e607f9404e190c21be18a9f', 'c666e1a82b8627690120cc43dbe79e9ec94ba5c3f6207d7c2f53cfa03e9db0b9', new DateTimeImmutable('2018-02-24 01:00:00'), 'php-blockchain best lib for blockchain in PHP'));

        self::assertTrue($chain->isValid());
    }

    public function testBlockchainGenesisBlockValidation(): void
    {
        $chain = new Blockchain(new Block(0, '54f669382364d526982eb06973688597499f1b22b19b4e5145a5fa0fd4fead60', '', new DateTimeImmutable('2018-02-23 23:59:59'), 'PHP is awesome!'));

        self::assertFalse($chain->isValid());
    }

    public function testBlockchainWithWrongBlockValidation(): void
    {
        $chain = new Blockchain(new Block(55, 'c666e1a82b8627690120cc43dbe79e9ec94ba5c3f6207d7c2f53cfa03e9db0b9', '44f669382364d526982eb06973688597499f1b22b19b4e5145a5fa0fd4fead60', new DateTimeImmutable('2018-02-24 01:00:00'), 'php-ml best lib for machine learning in PHP'));
        $this->addInvalidBlockToChain($chain, new Block(2, '87ce6a4efd23ce946ca907236e2d11b499a9e4bf3e607f9404e190c21be18a9f', 'c666e1a82b8627690120cc43dbe79e9ec94ba5c3f6207d7c2f53cfa03e9db0b9', new DateTimeImmutable('2018-02-24 01:00:00'), 'php-blockchain best lib for blockchain in PHP'));

        self::assertFalse($chain->isValid());
    }

    private function addInvalidBlockToChain(Blockchain $blockchain, Block $block): void
    {
        $reflection = new ReflectionClass(Blockchain::class);
        $blocksProperty = $reflection->getProperty('blocks');
        $blocksProperty->setAccessible(true);

        $blocks = $blocksProperty->getValue($blockchain);
        $blocks[] = $block;

        $blocksProperty->setValue($blockchain, $blocks);
    }
}
