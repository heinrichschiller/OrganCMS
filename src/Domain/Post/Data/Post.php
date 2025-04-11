<?php

declare(strict_types=1);

namespace App\Domain\Post\Data;

use DateTimeImmutable;

final class Post
{
    /**
     * The constructor.
     *
     * @param int|null $id Post id.
     * @param string|null $title Post title.
     * @param string|null $slug Post slug.
     * @param string|null $intro Post intro.
     * @param string|null $content Post content.
     * @param int|null $authorId Author id.
     * @param bool|null $onMainpage Show this Post on Mainpage.
     * @param string|null $publishedAt Post published date.
     * @param bool|null $isPublished Post is published or not.
     * @param string|null $createdAt Post creation date.
     * @param string|null $updatedAt Post update date.
     */
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $slug = null,
        private ?string $intro = null,
        private ?string $content = null,
        private ?int $authorId = null,
        private ?bool $onMainpage = null,
        private ?string $publishedAt = null,
        private ?bool $isPublished = null,
        private ?string $createdAt = null,
        private ?string $updatedAt = null
    ) {
        $this->setTitle($title);
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
     * @param string|null $title Post title.
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
     * Get slug.
     *
     * @return string|null
     */
    public function getSlug(): string|null
    {
        return $this->slug;
    }

    /**
     * Get intro.
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
     * Get author.
     *
     * @return int|null
     */
    public function getAuthorId(): int|null
    {
        return $this->authorId;
    }

    /**
     * On mainpage.
     *
     * @return bool
     */
    public function onMainpage(): bool|null
    {
        return $this->onMainpage;
    }

    /**
     * Get published at.
     *
     * @return string|null
     */
    public function getPublishedAt(): string|null
    {
        return $this->publishedAt;
    }

    /**
     * Get published at formated as string.
     *
     * @return string|null
     */
    public function getPublishedAtFormated(): string|null
    {
        $date = null;

        if ($this->publishedAt !== null) {
            $date = new DateTimeImmutable($this->publishedAt);
            $date = $date->format('d.m.Y');
        }
        
        return $date;
    }

    /**
     * Is published.
     *
     * @return bool
     */
    public function isPublished(): bool|null
    {
        return $this->isPublished;
    }

    /**
     * Get created at.
     *
     * @return string|null
     */
    public function getCreatedAt(): string|null
    {
        return $this->createdAt;
    }

    /**
     * Get the formated date when an event was created.
     *
     * @return string|null
     */
    public function getCreatedAtFormated(): string|null
    {
        $date = null;

        if ($this->getCreatedAt() !== null) {
            $date = new DateTimeImmutable($this->createdAt);
            $date = $date->format('d.m.Y');
        }

        return $date;
    }

    /**
     * Get updated at.
     *
     * @return string|null
     */
    public function getUpdatedAt(): string|null
    {
        return $this->updatedAt;
    }

        /**
     * Get the formated date when an event was created.
     *
     * @return string
     */
    public function getUpdatedAtFormated(): string
    {
        $date = null;

        if ($this->updatedAt !== null) {
            $date = new DateTimeImmutable($this->createdAt);
            $date = $date->format('d.m.Y');
        }
        
        return $date;
    }
}
