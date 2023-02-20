<?php

declare(strict_types=1);

namespace App\Domain\Event;

use DateTime;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int|null $id
     */
    public function setId(int|null $id): void
    {
        $this->id = $id;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $title = trim($title, " \n\r\t\v\0");

        $this->title = ucfirst($title);
    }

    /**
     * Get place.
     *
     * @return string
     */
    public function getPlace(): string
    {
        return $this->place;
    }

    /**
     * Set place.
     *
     * @param string $place
     */
    public function setPlace(string $place): void
    {
        $place = trim($place);

        $this->place = ucfirst($place);
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * Set description.
     *
     * @param string $desc
     */
    public function setDesc(string $desc): void
    {
        $this->desc = $desc;
    }

    /**
     * Get event date.
     *
     * @return string
     */
    public function getEventDate(): string
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
        $date = new DateTime($this->eventDate);

        return $date->format('d.m.Y H:i');
    }

    /**
     * Set event date.
     *
     * @param string $date
     */
    public function setEventDate(string $date): void
    {
        $this->eventDate = $date;
    }

    /**
     * Event is published.
     *
     * @return bool
     */
    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    /**
     * Set published status.
     *
     * @param bool $published
     */
    public function setIsPublished(bool $published): void
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
     * Set date of the published event.
     *
     * @param string $currentDate
     */
    public function setPublishedOn(string $currentDate): void
    {
        $this->publishedOn = $currentDate;
    }

    /**
     * Get the date when an event was created.
     *
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt = '';
    }

    /**
     * Get the formated date when an event was created.
     *
     * @return string
     */
    public function getCreatedAtFormated(): string
    {
        $date = new DateTime($this->createdAt);

        return $date->format('d.m.Y');
    }

    /**
     * Set created date
     *
     * @param string|null $date
     */
    public function setCreatedAt(string|null $date): void
    {
        $this->createdAt = $date;
    }

    /**
     * Get the date when an event was created.
     *
     * @return string
     */
    public function getUpdatedAt(): string
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
        $date = new DateTime($this->createdAt);

        return $date->format('d.m.Y');
    }

    /**
     * Set created date
     *
     * @param string $date
     */
    public function setUpdatedAt(string $date): void
    {
        $this->createdAt = $date;
    }
}
