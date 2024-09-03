<?php

declare(strict_types=1);

namespace App\Factory;

use Psr\Log\LoggerInterface;

interface LoggerFactoryInterface
{
    /**
     * Add file handler.
     * 
     * @param string $filename Log filename
     * 
     * @return self;
     */
    public function addFileHandler(string $filename): self;

    /**
     * Create Logger
     * 
     * @return LoggerInterface
     */
    public function createLogger(): LoggerInterface;
}
