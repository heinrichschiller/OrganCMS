<?php

declare(strict_types=1);

namespace App\Domain\Donation;

final class Sound
{
    /**
     * The constructor.
     *
     * @param int|null $id
     * @param string|null $name
     * @param int|null $price
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $name = null,
        public readonly ?int $price = null
    ) {
    }
}
