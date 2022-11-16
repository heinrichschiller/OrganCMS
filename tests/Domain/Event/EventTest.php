<?php

declare(strict_types=1);

namespace Tests\Domain\Event;

use App\Domain\Event\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    private Event $event;

    public function setUp(): void
    {
        $this->event = new Event;
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventInstance(): void
    {
        $this->assertInstanceOf(Event::class, $this->event);
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventIdIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->event->getId());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventIdHasInput(): void
    {
        $this->event->setId(1);

        $this->assertEquals(1, $this->event->getId());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventTitleIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->event->getTitle());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventTitleHasInput(): void
    {
        $this->event->setTitle('Title');

        $this->assertSame('Title', $this->event->getTitle());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventTitleDoesNotStartOrEndWithAnWhitespace(): void
    {
        $this->event->setTitle(' Title ');

        $this->assertSame('Title', $this->event->getTitle());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventTitleDoesStartWithUppercase(): void
    {
        $this->event->setTitle(' title ');

        $this->assertSame('Title', $this->event->getTitle());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testPlaceIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->event->getPlace());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testPlaceHasInput(): void
    {
        $this->event->setPlace('Plauen');

        $this->assertSame('Plauen', $this->event->getPlace());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testPlaceDoesNotStartOrEndWithAnWhitespace(): void
    {
        $this->event->setPlace(' Plauen');

        $this->assertSame('Plauen', $this->event->getPlace());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testPlaceDoesStartWithAnUppercase(): void
    {
        $this->event->setPlace('plauen');

        $this->assertSame('Plauen', $this->event->getPlace());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testDescIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->event->getDesc());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testDescHasInput(): void
    {
        $text = 'A large Description with many text.';

        $this->event->setDesc($text);

        $this->assertSame($text, $this->event->getDesc());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEventDateIsEmptyByDefault(): void
    {
        $this->assertEmpty($this->event->getEventDate());
    }

    /**
     * @covers App\Domain\Event\Event
     */
    public function testEvenDateHasInput(): void
    {
        $this->event->setEventDate('05-13-2022');

        $this->assertEquals('05-13-2022', $this->event->getEventDate());
    }
}
