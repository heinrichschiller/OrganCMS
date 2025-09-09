<?php

declare(strict_types=1);

use App\Domain\Event\Data\Event;
use App\Domain\Event\Data\EventCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(EventCollection::class)]
#[CoversMethod(EventCollection::class, 'add')]
final class EventCollectionTest extends TestCase
{
    public function testAddAndIterade(): void
    {
        $collection = new EventCollection;

        $event1 = $this->createMock(Event::class);
        $event2 = $this->createMock(Event::class);

        $collection->add($event1);
        $collection->add($event2);

        $this->assertCount(2, iterator_to_array($collection));
        $this->assertSame([$event1, $event2], iterator_to_array($collection));
    }
}
