<?php

declare(strict_types=1);

namespace App\Domain\Post\Data;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, string>
 */
final class PostReaderResultCollection implements IteratorAggregate
{
    /**
     * @var PostReaderResult[]
     */
    private array $list = [];

    /**
     * Add a new Post to collection.
     *
     * @param PostReaderResult $post The news post.
     */
    public function add(PostReaderResult $post): void
    {
        $this->list[] = $post;
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
