<?php

declare(strict_types=1);

namespace App\Factory;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\HandlerInterface;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;

final class LoggerFactory implements LoggerFactoryInterface
{
    private string $path = '';
    private Level $level;
    /** @var array<HandlerInterface> */
    private array $handler = [];

    private ?LoggerInterface $testLogger = null;

    /**
     * @param array<mixed> $settings
     */
    public function __construct(array $settings)
    {
        $this->path = (string) $settings['path'] ?: 'vfs://root/logs';
        $this->level = $settings['level'] ?? Level::Debug;

        // This can be used for testing to make the Factory testable
        if (isset($settings['test'])) {
            $this->testLogger = $settings['test'];
        }
    }

    public function createLogger(string|null $name = null): LoggerInterface
    {
        if ($this->testLogger !== null) {
            //$this->handler = [$this->testLogger];
            return $this->testLogger;
        }

        $logger = new Logger($name ?? Uuid::v4()->toRfc4122());

        foreach ($this->handler as $handler) {
            $logger->pushHandler($handler);
        }

        $this->handler = [];

        return $logger;
    }

    public function addHandler(HandlerInterface $handler):self
    {
        $this->handler[] = $handler;

        return $this;
    }

    public function addFileHandler(string $filename, ?Level $level = null): self
    {
        $filename = sprintf("%s/%s", $this->path, $filename);
        $rotatingFileHandler = new RotatingFileHandler($filename, 0, $level ?? $this->level, true, 0777);

        // The last "true" here tells monolog to remove empty arrays
        $rotatingFileHandler->setFormatter(new LineFormatter(null, null, false, true));

        $this->addHandler($rotatingFileHandler);

        return $this;
    }

    public function addConsoleHandler(?Level $level = null): self
    {
        $streamHandler = new StreamHandler('php://output', $level ?? $this->level);

        // The last "true" here tells monolog to remove empty arrays
        $streamHandler->setFormatter(new LineFormatter(null, null, false, true));

        $this->addHandler($streamHandler);

        return $this;
    }
}
