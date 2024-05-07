<?php

declare(strict_types=1);

namespace App\Domain\Event\Data;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, string>
 */
final class EventCollection implements IteratorAggregate
{
    /**
     * @var array<Event>
     */
    private array $list = [];

    /**
     * Add a new event to collection.
     *
     * @param Event $event Event entry.
     */
    public function add(Event $event): void
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
