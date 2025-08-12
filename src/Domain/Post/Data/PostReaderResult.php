<?php declare(strict_types=1);

namespace App\Domain\Post\Data;

use DateTimeImmutable;

use function trim;
use function ucfirst;

final class PostReaderResult
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
     * @param DateTimeImmutable|null $publishedAt Post published date.
     * @param bool $isPublished Post is published or not.
     * @param DateTimeImmutable|null $createdAt Post creation date.
     * @param DateTimeImmutable|null $updatedAt Post update date.
     */
    public function __construct(
        private ?int $id = null,
        private ?string $title = null,
        private ?string $slug = null,
        private ?string $intro = null,
        private ?string $content = null,
        private ?bool $onMainpage = null,
        private ?DateTimeImmutable $publishedAt = null,
        private ?bool $isPublished = null,
        private ?DateTimeImmutable $createdAt = null,
        private ?DateTimeImmutable $updatedAt = null
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
        if ($title !== null) {
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
     * On mainpage.
     *
     * @return bool|null
     */
    public function onMainpage(): bool|null
    {
        return $this->onMainpage;
    }

    /**
     * Get published at.
     *
     * @return DateTimeImmutable|null
     */
    public function getPublishedAt(): DateTimeImmutable|null
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
            $date = $this->publishedAt->format('d.m.Y');
        }

        return $date;
    }

    /**
     * Is published.
     *
     * @return bool|null
     */
    public function isPublished(): bool|null
    {
        return $this->isPublished;
    }

    /**
     * Get created at.
     *
     * @return DateTimeImmutable|null
     */
    public function getCreatedAt(): DateTimeImmutable|null
    {
        return $this->createdAt;
    }

    /**
     * Get created at formated in german time.
     * Format: d.m.Y - 06.09.2024
     * 
     * @return string
     */
    public function getCreatedAtFormated(): string|null
    {
        $date = null;

        if($this->createdAt !== null) {
            $date = $this->createdAt->format('d.m.Y');
        }

        return $date;
    }

    /**
     * Get updated at.
     *
     * @return DateTimeImmutable|null
     */
    public function getUpdatedAt(): DateTimeImmutable|null
    {
        return $this->updatedAt;
    }

    /**
     * Get updated at formated in german time.
     * Format: d.m.Y - 06.09.2024
     * 
     * @return string
     */
    public function getUpdatedAtFormated(): string|null
    {
        $date = null;

        if ($this->updatedAt !== null) {
            $date = $this->updatedAt->format('d.m.Y');
        }

        return $date;
    }
}
