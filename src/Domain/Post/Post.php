<?php

declare(strict_types=1);

namespace App\Domain\Post;

use SebastianBergmann\Type\NullType;

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
     * @param bool $onMainpage Show this Post on Mainpage.
     * @param string|null $publishedAt Post published date.
     * @param bool $isPublished Post is published or not.
     * @param string|null $author Author.
     * @param string|null $createdAt Post creation date.
     * @param string|null $updatedAt Post update date.
     */
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $slug = null,
        private ?string $intro = null,
        private ?string $content = null,
        private ?string $author = null,
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
     * @return string|null
     */
    public function getAuthor(): string|null
    {
        return $this->author;
    }

    /**
     * On mainpage.
     *
     * @return bool
     */
    public function onMainpage(): bool
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
     * Is published.
     *
     * @return bool
     */
    public function isPublished(): bool
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
     * Get updated at.
     *
     * @return string|null
     */
    public function getUpdatedAt(): string|null
    {
        return $this->updatedAt;
    }
}
