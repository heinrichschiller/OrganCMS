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
        private int $id = 0,
        private string $name = '',
        private bool $isPublished = false,
        private string $publishedAt = '',
        private string $createdAt = '',
        private string|null $updatedAt = '',
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
     * @return string $updatedAt Get updated date
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
