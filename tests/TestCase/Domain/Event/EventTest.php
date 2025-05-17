<?php

declare(strict_types=1);

namespace Tests\TestCase\Domain\Event;

use App\Domain\Event\Data\Event;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Event::class)]
#[CoversMethod(Event::class, 'getId')]
#[CoversMethod(Event::class, 'getTitle')]
#[CoversMethod(Event::class, 'getSlug')]
#[CoversMethod(Event::class, 'getIntro')]
#[CoversMethod(Event::class, 'getContent')]
#[CoversMethod(Event::class, 'getPlace')]
#[CoversMethod(Event::class, 'getAuthorId')]
#[CoversMethod(Event::class, 'getEventDate')]
#[CoversMethod(Event::class, 'getOnMainpage')]
#[CoversMethod(Event::class, 'isPublished')]
#[CoversMethod(Event::class, 'getPublishedAt')]
#[CoversMethod(Event::class, 'getCreatedAt')]
#[CoversMethod(Event::class, 'getUpdatedAt')]
class EventTest extends TestCase
{
    public function setUp(): void
    {
        // do nothing
    }

    public function testEventIsCreatedWithValues(): void
    {
        $eventDate = new DateTimeImmutable('2025-05-15');
        $publishedAt = new DateTimeImmutable('2025-05-15');
        $createdAt = new DateTimeImmutable('2025-05-15');
        $updatedAt = new DateTimeImmutable('2025-05-15');

        $event = new Event(
            id: 1,
            title: '  test event ',
            slug: 'test-event/test/event',
            intro: 'Intro text',
            content: 'Full content here.',
            place: ' berlin ',
            authorId: 42,
            eventDate: $eventDate,
            onMainpage: true,
            isPublished: true,
            publishedAt: $publishedAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        $this->assertSame(1, $event->getId());
        $this->assertSame('Test event', $event->getTitle());
        $this->assertSame('test-event/test/event', $event->getSlug());
        $this->assertSame('Intro text', $event->getIntro());
        $this->assertSame('Full content here.', $event->getContent());
        $this->assertSame('Berlin', $event->getPlace());
        $this->assertSame(42, $event->getAuthorId());
        $this->assertEquals($eventDate, $event->getEventDate());
        $this->assertTrue($event->getOnMainpage());
        $this->assertTrue($event->isPublished());
        $this->assertEquals($publishedAt, $event->getPublishedAt());
        $this->assertEquals($createdAt, $event->getCreatedAt());
        $this->assertEquals($updatedAt, $event->getUpdatedAt());
    }
}
