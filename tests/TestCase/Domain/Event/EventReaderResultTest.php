<?php

declare(strict_types=1);

namespace Tests\TestCase\Domain\Event;

use App\Domain\Event\Data\EventReaderResult;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(EventReaderResult::class)]
#[CoversMethod(EventReaderResult::class, 'getId')]
#[CoversMethod(EventReaderResult::class, 'getTitle')]
#[CoversMethod(EventReaderResult::class, 'getSlug')]
#[CoversMethod(EventReaderResult::class, 'getIntro')]
#[CoversMethod(EventReaderResult::class, 'getContent')]
#[CoversMethod(EventReaderResult::class, 'getPlace')]
#[CoversMethod(EventReaderResult::class, 'getAuthorId')]
#[CoversMethod(EventReaderResult::class, 'getEventDate')]
#[CoversMethod(EventReaderResult::class, 'getOnMainpage')]
#[CoversMethod(EventReaderResult::class, 'isPublished')]
#[CoversMethod(EventReaderResult::class, 'getPublishedAt')]
#[CoversMethod(EventReaderResult::class, 'getCreatedAt')]
#[CoversMethod(EventReaderResult::class, 'getUpdatedAt')]
class EventReaderResultTest extends TestCase
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

        $event = new EventReaderResult(
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
        $this->assertSame('15.05.2025', $event->getEventDateFormated());
        $this->assertTrue($event->getOnMainpage());
        $this->assertTrue($event->isPublished());
        $this->assertEquals($publishedAt, $event->getPublishedAt());
        $this->assertSame('15.05.2025', $event->getPublishedAtFormated());
        $this->assertEquals($createdAt, $event->getCreatedAt());
        $this->assertSame('15.05.2025', $event->getCreatedAtFormated());
        $this->assertEquals($updatedAt, $event->getUpdatedAt());
        $this->assertSame('15.05.2025', $event->getUpdatedAtFormated());
    }
}
