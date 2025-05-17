<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Data;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<int, string>
 */
final class SupporterCollection implements IteratorAggregate
{
    /**
     * @var array<Supporter>
     */
    private array $list = [];

    /**
     * Add a new Supporter to collection.
     *
     * @param Supporter $supporter Supporter.
     */
    public function add(Supporter $supporter): void
    {
        $this->list[] = $supporter;
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
