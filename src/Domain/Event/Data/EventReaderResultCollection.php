<?php

declare(strict_types=1);

namespace App\Domain\Event\Data;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, string>
 */
final class EventReaderResultCollection implements IteratorAggregate
{
    /**
     * @var array<EventReaderResult>
     */
    private array $list = [];

    /**
     * Add a new event to collection.
     *
     * @param EventReaderResult $event EventReaderResult entry.
     */
    public function add(EventReaderResult $event): void
    {
        $this->list[] = $event;
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
