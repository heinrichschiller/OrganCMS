<?php

declare(strict_types=1);

namespace App\Domain\Data\Author;

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
}
