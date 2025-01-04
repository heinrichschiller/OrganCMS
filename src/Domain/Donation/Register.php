<?php

declare(strict_types=1);

namespace App\Domain\Donation;

final class Register
{
    /**
     * The constructor.
     *
     * @param int|null $id
     * @param string|null $name Register name
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly ?string $name = null
    ) {
    }
}
