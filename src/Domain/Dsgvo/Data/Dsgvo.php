<?php

declare(strict_types=1);

namespace App\Domain\Dsgvo\Data;

use DateTimeImmutable;

final class Dsgvo
{
    public function __construct(
        private ?string $details = null,
        private ?DateTimeImmutable $updatedAt = null,
    ) {
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
