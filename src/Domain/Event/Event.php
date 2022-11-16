<?php

declare(strict_types=1);

namespace App\Domain\Event;

use DateTime;

final class Event
{
    /**
     * @var int
     */
    private int $id = 0;

    /**
     * @var string
     */
    private string $title = '';

    /**
     * @var string
     */
    private string $place = '';

    /**
     * @var string
     */
    private string $desc = '';

    /**
     * @var string
     */
    private string $eventDate = '';

    /**
     * @var bool
     */
    private bool $published = false;

    /**
     * @var string
     */
    private string $publishedOn = '';

    /**
     * @var string
     */
    private string $createdAt = '';

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
     * @param int $id
     */
    public function setId(int $id): void
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
        return $this->published;
    }

    /**
     * Set published status.
     *
     * @param bool $published
     */
    public function setPublished(bool $published): void
    {
        $this->published = $published;
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
     * @param string $date
     */
    public function setCreatedAt(string $date): void
    {
        $this->createdAt = $date;
    }
}
