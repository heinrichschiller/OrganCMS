<?php

declare(strict_types=1);

namespace App\Domain\Post;

final class Post
{
    /**
     * The constructor.
     *
     * @param int $id Post id.
     * @param string $title Post title.
     * @param string $slug Post slug.
     * @param string $content Post content.
     * @param bool $onMainpage Show this Post on Mainpage.
     * @param string $publishedAt Post published date.
     * @param bool $isPublished Post is published or not.
     * @param string $author Author.
     * @param string $createdAt Post creation date.
     * @param string $updatedAt Post update date.
     */
    public function __construct(
        private int $id = 0,
        private string $title = '',
        private string $slug = '',
        private string $content = '',
        private string $author = '',
        private bool $onMainpage = false,
        private string $publishedAt = '',
        private bool $isPublished = false,
        private string $createdAt = '',
        private string $updatedAt = ''
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
