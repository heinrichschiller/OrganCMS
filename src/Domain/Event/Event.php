<?php

declare(strict_types=1);

namespace App\Domain\Event;

use DateTimeImmutable;

final class Event
{
    /**
     * The constructor.
     *
     * @param int|null $id Event id.
     * @param string|null $title Event title.
     * @param string|null $place Event place.
     * @param string|null $desc  Event description.
     * @param string|null $eventDate Event date.
     * @param bool|null $isPublished Event status.
     * @param string|null $publishedOn Date when the event was published.
     * @param string|null $createdAt Date when the event was created.
     * @param string|null $updatedAt Date when the event was updated.
     */
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $place = null,
        private ?string $desc = null,
        private ?string $eventDate = null,
        private ?bool $isPublished = null,
        private ?string $publishedOn = null,
        private ?string $createdAt = null,
        private ?string $updatedAt = null
    ) {
        $this->setId($id);
        $this->setTitle($title);
        $this->setPlace($place);
        $this->setDesc($desc);
        $this->setEventDate($eventDate);
        $this->setIsPublished($isPublished);
        $this->setPublishedOn($publishedOn);
        $this->setCreatedAt($createdAt);
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
     * Set id.
     *
     * @param int|null $id
     */
    private function setId(int|null $id): void
    {
        $this->id = $id;
    }

    /**
     * Get title.
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
        if (null !== $title) {
            $title = trim($title, " \n\r\t\v\0");
            $title = ucfirst($title);
        }
        
        $this->title = $title;
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
     * Set place.
     *
     * @param string|null $place
     */
    private function setPlace(string|null $place): void
    {
        if (null !== $place) {
            $place = trim($place);
            $place = ucfirst($place);
        }
        
        $this->place = $place;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDesc(): string|null
    {
        return $this->desc;
    }

    /**
     * Set description.
     *
     * @param string|null $desc
     */
    private function setDesc(string|null $desc): void
    {
        $this->desc = $desc;
    }

    /**
     * Get event date.
     *
     * @return string|null
     */
    public function getEventDate(): string|null
    {
        return $this->eventDate;
    }

    /**
     * Get formated event date.
     *
     * @return string
     */
    public function getEventDateFormated(): string
    {
        $date = new DateTimeImmutable($this->eventDate);

        return $date->format('d.m.Y');
    }

    /**
     * Get published at.
     *
     * @return string|null
     */
    public function getEventTime(): string|null
    {
        $date = new DateTimeImmutable($this->eventDate);

        return $date->format('H:i');
    }

    /**
     * Set event date.
     *
     * @param string|null $date
     */
    private function setEventDate(string|null $date): void
    {
        $this->eventDate = $date;
    }

    /**
     * Event is published.
     *
     * @return bool|null
     */
    public function isPublished(): bool|null
    {
        return $this->isPublished;
    }

    /**
     * Set published status.
     *
     * @param bool|null $published
     */
    private function setIsPublished(bool|null $published): void
    {
        $this->isPublished = $published;
    }

    /**
     * Get the date of the published event.
     *
     * @return string
     */
    public function getPublishedOn(): string
    {
        return $this->publishedOn;
    }

    /**
     * Get the date of the published event.
     *
     * @return string
     */
    public function getPublishedOnFormated(): string
    {
        $date = new DateTimeImmutable($this->publishedOn);

        return $date->format('d.m.Y');
    }

    /**
     * Set date of the published event.
     *
     * @param string|null $currentDate
     */
    private function setPublishedOn(string|null $currentDate): void
    {
        $this->publishedOn = $currentDate;
    }

    /**
     * Get the date when an event was created.
     *
     * @return string|null
     */
    public function getCreatedAt(): string|null
    {
        return $this->createdAt = '';
    }

    /**
     * Get the formated date when an event was created.
     *
     * @return string|null
     */
    public function getCreatedAtFormated(): string|null
    {
        $date = new DateTimeImmutable($this->createdAt);

        return $date->format('d.m.Y');
    }

    /**
     * Set created date
     *
     * @param string|null $date
     */
    private function setCreatedAt(string|null $date): void
    {
        $this->createdAt = $date;
    }

    /**
     * Get the date when an event was created.
     *
     * @return string|null
     */
    public function getUpdatedAt(): string|null
    {
        return $this->createdAt = '';
    }

    /**
     * Get the formated date when an event was created.
     *
     * @return string
     */
    public function getUpdatedAtFormated(): string
    {
        $date = new DateTimeImmutable($this->createdAt);

        return $date->format('d.m.Y');
    }

    /**
     * Set created date
     *
     * @param string|null $date
     */
    private function setUpdatedAt(string|null $date): void
    {
        $this->createdAt = $date;
    }
}
