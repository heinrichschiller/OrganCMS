<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Dashboard\Service;

use App\Domain\Dashboard\Service\DashboardReader;
use App\Domain\Donation\Data\DonationDetails;
use App\Domain\Donation\Service\DonationDetailsFinder;
use App\Domain\Event\Data\Event;
use App\Domain\Event\Data\EventCollection;
use App\Domain\Event\Service\EventFinder;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DashboardReader::class)]
#[UsesClass(DonationDetails::class)]
#[UsesClass(Event::class)]
#[UsesClass(EventCollection::class)]
#[usesClass(EventFinder::class)]
final class DashboardReaderTest extends TestCase
{
    #[Test]
    public function testReadReturnsMergedData(): void
    {
        $donation = new DonationDetails(
            total: '123.45',
            date: '2025-01-15',
            user: 'alice'
        );

        $detailsFinder = $this->createMock(DonationDetailsFinder::class);
        $detailsFinder
            ->expects($this->once())
            ->method('findOne')
            ->willReturn($donation);

        $event = new Event(
            id: 1,
            title: 'My Event',
            slug: 'my-event',
            intro: 'Intro',
            content: 'Content',
            place: 'Berlin',
            eventDate: new DateTimeImmutable('2025-02-01'),
            publishedAt: new DateTimeImmutable('2025-01-10'),
            isPublished: true,
            createdAt: new DateTimeImmutable('2024-12-31'),
            updatedAt: new DateTimeImmutable('2025-01-05'),
        );

        $collection = new EventCollection();
        $collection->add($event);

        $eventFinder = $this->createMock(EventFinder::class);
        $eventFinder
            ->expects($this->once())
            ->method('findPublishedEvents')
            ->willReturn($collection);

        $sut = new DashboardReader($detailsFinder, $eventFinder);

        $result = $sut->read();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('user', $result);
        $this->assertArrayHasKey('donation', $result);
        $this->assertArrayHasKey('event', $result);
    }
}
