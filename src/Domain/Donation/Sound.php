<?php

declare(strict_types=1);

namespace App\Domain\Donation;

final class Sound
{
    /**
     * The constructor
     * 
     * @param readonly int $id
     * @param readonly string $name
     * @param readonly int $price
     */
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $price
    ) {}
}
