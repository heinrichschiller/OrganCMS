<?php

declare(strict_types=1);

namespace App\Domain\Post;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, string>
 */
final class PostCollection implements IteratorAggregate
{
    /**
     * @var Post[]
     */
    private array $list = [];

    /**
     * Add a new Post to collection.
     *
     * @param Post $post The news post.
     */
    public function add(Post $post): void
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
