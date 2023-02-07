<?php

declare(strict_types=1);

namespace App\Domain\Supporter;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, string>
 */
final class SupporterCollection implements IteratorAggregate
{
    /**
     * @var Supporter[]
     */
    private array $list = [];

    /**
     * Add a new Supporter to collection.
     *
     * @param Supporter $supporter Supporter.
     */
    public function add(Supporter $post): void
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
