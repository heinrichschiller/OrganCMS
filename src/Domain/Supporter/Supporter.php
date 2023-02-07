<?php

declare(strict_types=1);

namespace App\Domain\Supporter;

final class Supporter
{
    /**
     * The constructor.
     *
     * @param int $id Supporter id.
     * @param string $name Supporter name.
     * @param bool isPublished Is supporter published.
     * @param string $publishedAt
     * @param string $createdAt
     * @param string|null $updatedAt
     */
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?bool $isPublished = null,
        private ?string $publishedAt = null,
        private ?string $createdAt = null,
        private ?string $updatedAt = null,
    ) {
        $this->setName($name);
    }

    /**
     * Get supporter id.
     *
     * @return int $id Supporter id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get supporter name
     *
     * @return string $name Supporter name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set supporter name
     *
     * @param string $name Supporter name.
     */
    private function setName(string $name): void
    {
        $name = trim($name, " \n\r\t\v\0");

        $this->name = $name;
    }

    /**
     * Get supporter public status
     *
     * @return bool $isPublished Supporter public status
     */
    public function isPublished(): bool
    {
        return $this->isPublished;
    }

    /**
     * Get published date.
     *
     * @return string $publishedAt Published date
     */
    public function getPublishedAt(): string
    {
        return $this->publishedAt;
    }

    /**
     * Get created date.
     *
     * @return string $createdAt Get created date
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * Get updated date.
     *
     * @return string|null $updatedAt Get updated date
     */
    public function getUpdatedAt(): string|null
    {
        return $this->updatedAt;
    }
}
