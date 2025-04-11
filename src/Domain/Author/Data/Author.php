<?php

declare(strict_types=1);

namespace App\Domain\Author\Data;

final class Author
{
    /**
     * @param null|int $id Author id.
     * @param null|int $userId User id (Is a user also an author or not).
     * @param null|string $authorName Author name
     */
    public function __construct(
        private ?int $id = null,
        private ?int $userId = null,
        private ?string $authorName = null
    ) {
    }

    /**
     * Get author id.
     *
     * @return int Author idl
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * Get user id.
     *
     * @return int User id.
     */
    public function getUserId(): int|null
    {
        return $this->userId;
    }

    /**
     * Get author name.
     *
     * @return string Author name.
     */
    public function getAuthorName(): string|null
    {
        return $this->authorName;
    }
}
