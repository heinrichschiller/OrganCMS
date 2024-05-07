<?php

declare(strict_types=1);

namespace Tests\Domain\Event;

use App\Domain\Event\Data\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventInstance(): void
    {
        $event = new Event;

        $this->assertInstanceOf(Event::class, $event);
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventIdIsNullByDefault(): void
    {
        $event = new Event;

        $this->assertNull($event->getId());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventIdHasInput(): void
    {
        $event = new Event(1);

        $this->assertEquals(1, $event->getId());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventTitleIsNullByDefault(): void
    {
        $event = new Event(1);

        $this->assertNull($event->getTitle());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventTitleHasInput(): void
    {
        $event = new Event(1, 'Title');

        $this->assertSame('Title', $event->getTitle());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventTitleDoesNotStartOrEndWithAnWhitespace(): void
    {
        $event = new Event(1, ' Title ');

        $this->assertSame('Title', $event->getTitle());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventTitleDoesStartWithUppercase(): void
    {
        $event = new Event(1, 'title');

        $this->assertSame('Title', $event->getTitle());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testPlaceIsNullByDefault(): void
    {
        $event = new Event(1, 'Title');

        $this->assertNull($event->getPlace());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testPlaceHasInput(): void
    {
        $event = new Event(1, 'Title', 'Plauen');

        $this->assertSame('Plauen', $event->getPlace());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testPlaceDoesNotStartOrEndWithAnWhitespace(): void
    {
        $event = new Event(1, 'Title', ' Plauen ');

        $this->assertSame('Plauen', $event->getPlace());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testPlaceDoesStartWithAnUppercase(): void
    {
        $event = new Event(1, 'Title', 'plauen');

        $this->assertSame('Plauen', $event->getPlace());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testDescIsNullByDefault(): void
    {
        $event = new Event(1, 'Title', 'Plauen');

        $this->assertNull($event->getDesc());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testDescHasInput(): void
    {
        $text = 'A large Description with many text.';

        $event = new Event(1, 'Title', 'Plauen', $text);

        $this->assertSame($text, $event->getDesc());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventDateIsNullByDefault(): void
    {
        $text = 'A large Description with many text.';

        $event = new Event(1, 'Title', 'Plauen', $text);

        $this->assertNull($event->getEventDate());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEvenDateHasInput(): void
    {
        $text = 'A large Description with many text.';

        $event = new Event(1, 'Title', 'Plauen', $text, '05-13-2022');

        $this->assertEquals('05-13-2022', $event->getEventDate());
    }
}
