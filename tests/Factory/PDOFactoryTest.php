<?php

namespace Tests\Factory;

use App\Factory\PDOFactory;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;

class PDOFactoryTest extends TestCase
{
    private Logger $logger;
    private array $options = [];

    public function setUp(): void
    {
        $this->logger = new Logger('Test');
        $this->options = [
            'type' => 'sqlite',
            'dbname' => 'memory'
        ];
    }

    /**
     * @covers App\Factory\PDOFactory
     */
    public function testPdoConnectionIsCreated(): void
    {
        $pdoFactory = new PDOFactory(
            $this->logger,
            $this->options
        );

        $pdo = $pdoFactory->create();

        $this->assertInstanceOf('PDO', $pdo);
    }

    /**
     * @covers App\Factory\PDOFactory
     */
    public function testPDOConnectionThrownPdoException(): void
    {
        $this->expectException('Exception');

        $options = [
            'type' => '...',
            'dbname' => '...'
        ];

        $pdoFactory = new PDOFactory(
            $this->logger,
            $options
        );

        $pdo = $pdoFactory->create();
    }
}
