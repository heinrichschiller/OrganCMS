<?php

declare(strict_types=1);

namespace App\Domain\Event\Data;

use DateTimeImmutable;

/**
 * Event
 */
final class Event
{
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $slug = null,
        private ?string $content = null,
        private ?string $place = null,
        private ?DateTimeImmutable $eventDate = null,
        private ?bool $isPublished = null,
        private ?DateTimeImmutable $publishedAt = null,
        private ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt = null
    ) {
        $this->setTitle($title);
        $this->setPlace($place);
    }

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getTitle(): string|null
    {
        return $this->title;
    }

    private function setTitle(string|null $title): void
    {
        if ($title !== null) {
            $title = trim($title, " \n\r\t\v\0");
            $title = ucfirst($title);
        }
        
        $this->title = $title;
    }

    public function getSlug(): string|null
    {
        return $this->slug;
    }

    public function getContent(): string|null
    {
        return $this->content;
    }

    public function getPlace(): string|null
    {
        return $this->place;
    }

    private function setPlace(string|null $place): void
    {
        if ($place !== null) {
            $place = trim($place);
            $place = ucfirst($place);
        }
        
        $this->place = $place;
    }

    public function getEventDate(): DateTimeImmutable|null
    {
        return $this->eventDate;
    }

    public function getEventDateFormated(): string
    {
        $eventDate = '';

        if ($this->eventDate !== null) {
            $eventDate = $this->eventDate->format('Y-m-d\TH:i');
        }

        return $eventDate;
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
        $publishedAt = '';

        if ($this->publishedAt !== null) {
            $publishedAt = $this->publishedAt->format('Y-m-d\TH:i');
        }

        return $publishedAt;
    }

    public function getCreatedAt(): DateTimeImmutable|null
    {
        return $this->createdAt;
    }

    public function getCreatedAtFormated(): string
    {
        $createdAt = '';

        if ($this->createdAt !== null) {
            $createdAt = $this->createdAt->format('d.m.Y');
        }

        return $createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable|null
    {
        return $this->updatedAt;
    }

    public function getUpdatedAtFormated(): string
    {
        $updatedAt = '';

        if ($this->updatedAt !== null) {
            $updatedAt = $this->updatedAt->format('d.m.Y');
        }

        return $updatedAt;
    }
}
