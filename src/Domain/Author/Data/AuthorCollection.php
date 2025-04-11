<?php

declare(strict_types=1);

namespace App\Domain\Author\Data;

use App\Domain\Author\Data\Author;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, string>
 */
final class AuthorCollection implements IteratorAggregate
{
    /**
     * @var array<Author>
     */
    private array $list = [];

    /**
     * Add a new Author to collection.
     *
     * @param Author $Author Author entry.
     */
    public function add(Author $Author): void
    {
        $this->list[] = $Author;
    }

    /**
     * Iterate over this collection.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }
}
