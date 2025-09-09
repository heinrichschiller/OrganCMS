<?php

declare(strict_types=1);

use App\Domain\Event\Data\EventReaderResult;
use App\Domain\Event\Data\EventReaderResultCollection;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(EventReaderResultCollection::class)]
#[CoversMethod(EventReaderResultCollection::class, 'add')]
final class EventReaderResultCollectionTest extends TestCase
{
    public function testAddAndIterade(): void
    {
        $collection = new EventReaderResultCollection;

        $event1 = $this->createMock(EventReaderResult::class);
        $event2 = $this->createMock(EventReaderResult::class);

        $collection->add($event1);
        $collection->add($event2);

        $this->assertCount(2, iterator_to_array($collection));
        $this->assertSame([$event1, $event2], iterator_to_array($collection));
    }
}
