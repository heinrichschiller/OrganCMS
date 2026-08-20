<?php

declare(strict_types=1);

namespace App\Domain\Event\Data;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, EventReaderResult>
 */
final class EventReaderResultCollection implements IteratorAggregate
{
    /**
     * @var array<EventReaderResult>
     */
    private array $list = [];

    public function add(EventReaderResult $event): void
    {
        $this->list[] = $event;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }
}
