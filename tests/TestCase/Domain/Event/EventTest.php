<?php

declare(strict_types=1);

namespace Tests\TestCase\Domain\Event;

use App\Domain\Event\Data\Event;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Event::class)]
#[CoversMethod(Event::class, 'getId')]
#[CoversMethod(Event::class, 'getTitle')]
#[CoversMethod(Event::class, 'getPlace')]
#[CoversMethod(Event::class, 'getDesc')]
#[CoversMethod(Event::class, 'getEventDate')]
class EventTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    public function testEventInstance(): void
    {
        $event = new Event;

        $this->assertInstanceOf(Event::class, $event);
    }

    public function testEventPropertiesAreNullByDefault(): void
    {
        $event = new Event;

        $this->assertNull($event->getId());
        $this->assertNull($event->getTitle());
        $this->assertNull($event->getPlace());
        $this->assertNull($event->getDesc());
        $this->assertNull($event->getEventDate());
        $this->assertNull($event->isPublished());
        $this->assertNull($event->getPublishedOn());
        $this->assertNull($event->getCreatedAt());
        $this->assertNull($event->getUpdatedAt());
    }

    public function testEventIdHasInput(): void
    {
        $event = new Event(1);

        $this->assertEquals(1, $event->getId());
    }

    public function testEventTitleIsNullByDefault(): void
    {
        $event = new Event(1);

        
    }

    public function testEventTitleHasInput(): void
    {
        $event = new Event(1, 'Title');

        $this->assertSame('Title', $event->getTitle());
    }

    public function testEventTitleDoesNotStartOrEndWithAnWhitespace(): void
    {
        $event = new Event(1, ' Title ');

        $this->assertSame('Title', $event->getTitle());
    }

    public function testEventTitleDoesStartWithUppercase(): void
    {
        $event = new Event(1, 'title');

        $this->assertSame('Title', $event->getTitle());
    }

    public function testPlaceIsNullByDefault(): void
    {
        $event = new Event(1, 'Title');

        $this->assertNull($event->getPlace());
    }

    public function testPlaceHasInput(): void
    {
        $event = new Event(1, 'Title', 'Plauen');

        $this->assertSame('Plauen', $event->getPlace());
    }

    public function testPlaceDoesNotStartOrEndWithAnWhitespace(): void
    {
        $event = new Event(1, 'Title', ' Plauen ');

        $this->assertSame('Plauen', $event->getPlace());
    }

    public function testPlaceDoesStartWithAnUppercase(): void
    {
        $event = new Event(1, 'Title', 'plauen');

        $this->assertSame('Plauen', $event->getPlace());
    }

    public function testDescIsNullByDefault(): void
    {
        $event = new Event(1, 'Title', 'Plauen');

        $this->assertNull($event->getDesc());
    }

    public function testDescHasInput(): void
    {
        $text = 'A large Description with many text.';

        $event = new Event(1, 'Title', 'Plauen', $text);

        $this->assertSame($text, $event->getDesc());
    }

    public function testEventDateIsNullByDefault(): void
    {
        $text = 'A large Description with many text.';

        $event = new Event(1, 'Title', 'Plauen', $text);

        $this->assertNull($event->getEventDate());
    }

    public function testEvenDateHasInput(): void
    {
        $text = 'A large Description with many text.';

        $event = new Event(1, 'Title', 'Plauen', $text, '05-13-2022');

        $this->assertEquals('05-13-2022', $event->getEventDate());
    }
}
