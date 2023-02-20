<?php

declare(strict_types=1);

namespace App\Domain\Post;

final class Post
{
    /**
     * The constructor.
     *
     * @param int|null $id Post id.
     * @param string|null $title Post title.
     * @param string|null $slug Post slug.
     * @param string|null $content Post content.
     * @param bool|null $onMainpage Show this Post on Mainpage.
     * @param string|null $publishedAt Post published date.
     * @param bool|null $isPublished Post is published or not.
     * @param string|null $author Author.
     * @param string|null $createdAt Post creation date.
     * @param string|null $updatedAt Post update date.
     */
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $slug = null,
        private ?string $content = null,
        private ?string $author = null,
        private ?bool $onMainpage = null,
        private ?string $publishedAt = null,
        private ?bool $isPublished = null,
        private ?string $createdAt = '',
        private ?string $updatedAt = ''
    ) {
        $this->setTitle($title);
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
     * @param string $title Post title.
     */
    private function setTitle(string $title): void
    {
        $title = trim($title, " \n\r\t\v\0");

        $this->title = ucfirst($title);
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function onMainpage(): bool
    {
        return $this->onMainpage;
    }

    public function getPublishedAt(): string
    {
        return $this->publishedAt;
    }

    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
