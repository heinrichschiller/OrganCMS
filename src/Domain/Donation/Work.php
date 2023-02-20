<?php

declare(strict_types=1);

namespace App\Domain\Donation;

final class Work
{
    /**
     * The constructor
     *
     * @param int|null $id
     * @param string|null $name Work name
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $name = null
    ) {
    }
}
