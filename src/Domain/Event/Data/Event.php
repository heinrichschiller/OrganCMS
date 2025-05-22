<?php

declare(strict_types=1);

namespace App\Domain\Event\Data;

use DateTime;
use DateTimeImmutable;

/**
 * Event
 */
final class Event
{
    /**
     * The constructor.
     *
     * @param int|null $id Event id.
     * @param string|null $title Event title.
     * @param string|null $slug Event slug.
     * @param string|null $intro Event intro.
     * @param string|null $content Event content.
     * @param string|null $place Event place.
     * @param int|null $authorId Author id.
     * @param DateTimeImmutable|null $eventDate Event date.
     * @param bool|null $onMainpage Show this event on mainpage?
     * @param bool|null $isPublished Event status.
     * @param DateTimeImmutable|null $publishedAt Date when the event was published.
     * @param DateTimeImmutable|null $createdAt Date when the event was created.
     * @param DateTimeImmutable|null $updatedAt Date when the event was updated.
     */
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $slug = null,
        private ?string $intro = null,
        private ?string $content = null,
        private ?string $place = null,
        private ?int $authorId = null,
        private ?DateTimeImmutable $eventDate = null,
        private ?bool $onMainpage = null,
        private ?bool $isPublished = null,
        private ?DateTimeImmutable $publishedAt = null,
        private ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt = null
    ) {
        $this->setTitle($title);
        $this->setPlace($place);
    }

    /**
     * Get id.
     *
     * @return int|null
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * Get title of an event.
     *
     * @return string|null
     */
    public function getTitle(): string|null
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string|null $title
     */
    private function setTitle(string|null $title): void
    {
        if ($title !== null) {
            $title = trim($title, " \n\r\t\v\0");
            $title = ucfirst($title);
        }
        
        $this->title = $title;
    }

    /**
     * Get slug of an event.
     *
     *  @return string|null
     */
    public function getSlug(): string|null
    {
        return $this->slug;
    }

    /**
     * Get intro of an event.
     *
     * @return string|null
     */
    public function getIntro(): string|null
    {
        return $this->intro;
    }

    /**
     * Get content.
     *
     * @return string|null
     */
    public function getContent(): string|null
    {
        return $this->content;
    }

    /**
     * Get place.
     *
     * @return string|null
     */
    public function getPlace(): string|null
    {
        return $this->place;
    }

    /**
     * Set the event place.
     *
     * @param string|null $place
     */
    private function setPlace(string|null $place): void
    {
        if ($place !== null) {
            $place = trim($place);
            $place = ucfirst($place);
        }
        
        $this->place = $place;
    }

    /**
     * Get author id.
     *
     * @return int|null
     */
    public function getAuthorId(): int|null
    {
        return $this->authorId;
    }

    /**
     * Get event date.
     *
     * @return string|null
     */
    public function getEventDate(): DateTimeImmutable|null
    {
        return $this->eventDate;
    }

    /**
     * Show this event on mainpage or not.
     *
     * @return bool|null
     */
    public function getOnMainpage(): bool|null
    {
        return $this->onMainpage;
    }

    /**
     * Event status if is published or not.
     *
     * @return bool|null
     */
    public function isPublished(): bool|null
    {
        return $this->isPublished;
    }

    /**
     * Get the date of the published event.
     *
     * @return DateTimeImmutable|null
     */
    public function getPublishedAt(): DateTimeImmutable|null
    {
        return $this->publishedAt;
    }

    /**
     * Get the formated date of the published event.
     *
     * @return string|null
     */
    public function getPublishedAtFormated(): string|null
    {
        $publishedAt = '';

        if ($this->publishedAt !== null) {
            $publishedAt = $this->publishedAt->format('d.m.Y');
        }
    
        return $publishedAt;
    }

    /**
     * Get the date when an event was created.
     *
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): DateTimeImmutable|null
    {
        return $this->createdAt;
    }

    /**
     * Get the formated date when an event was created.
     *
     * @return |null
     */
    public function getCreatedAtFormated(): string|null
    {
        $createdAt = '';

        if ($this->createdAt !== null) {
            $createdAt = $this->createdAt->format('d.m.Y');
        }

        return $createdAt;
    }

    /**
     * Get the date when an event was created.
     *
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): DateTimeImmutable|null
    {
        return $this->updatedAt;
    }

    /**
     * Get the date when an event was created.
     *
     * @return string|null
     */
    public function getUpdatedAtFormated(): string|null
    {
        $updatedAt = '';

        if ($this->updatedAt !== null) {
            $updatedAt = $this->updatedAt->format('d.m.Y');
        }

        return $updatedAt;
    }
}
