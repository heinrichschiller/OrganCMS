<?php

declare(strict_types=1);

namespace App\Domain\Donation;

final class Work
{
    /**
     * The constructor
     * 
     * @param readonly int $id
     * @param readonly string $name
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
}
