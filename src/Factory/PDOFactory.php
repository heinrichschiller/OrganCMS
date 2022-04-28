<?php

declare(strict_types=1);

namespace App\Factory;

use Exception;
use Monolog\Logger;
use PDO;
use PDOException;

final class PDOFactory
{
    /**
     * Monolog logger
     *
     * @var Logger
     */
    private Logger $logger;

    /**
     * PDO options
     *
     * @var array
     */
    private array $options = [];

    /**
     * The contructor
     *
     * @param Logger $logger
     * @param array $options
     */
    public function __construct(Logger $logger, array $options = [])
    {
        $this->logger = $logger;
        $this->options = $options;
    }

    /**
     * Create a PDO database connection
     *
     * @return PDO
     */
    public function create(): PDO
    {
        $dsn = sprintf(
            '%s:%s',
            $this->options['type'],
            $this->options['dbname']
        );

        try {
            return new PDO($dsn);
        } catch (PDOException $e) {
            $this->logger->error($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}
