<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Data;

use DateTimeImmutable;

use function trim;

final class Supporter
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?bool $isPublished = false,
        private ?DateTimeImmutable $publishedAt = null,
        private ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt = null,
    ) {
        $this->setName($name);
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    private function setName(string|null $name): void
    {
        if (null !== $name) {
            $name = trim($name, " \n\r\t\v\0");
        }

        $this->name = $name;
    }

    public function isPublished(): bool|null
    {
        return $this->isPublished;
    }

    public function getPublishedAt(): DateTimeImmutable|null
    {
        return $this->publishedAt;
    }

    public function getPublishedAtFormated(): string
    {
        $date = '';

        if ($this->publishedAt !== null) {
            $date = $this->publishedAt->format('d.m.Y');
        }

        return $date;
    }

    public function getCreatedAt(): DateTimeImmutable|null
    {
        return $this->createdAt;
    }

    public function getCreatedAtFormated(): string
    {
        $date = '';

        if ($this->createdAt !== null) {
            $date = $this->createdAt->format('d.m.Y');
        }

        return $date;
    }

    public function getUpdatedAt(): DateTimeImmutable|null
    {
        return $this->updatedAt;
    }

    public function getUpdatedAtFormated(): string
    {
        $date = '';

        if ($this->updatedAt !== null) {
            $date = $this->updatedAt->format('d.m.Y');
        }

        return $date;
    }
}
