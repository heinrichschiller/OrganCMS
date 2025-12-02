<?php

declare(strict_types=1);

namespace Tests\TestCase\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Data\EventCollection;
use App\Domain\Event\Repository\EventFinderRepository;
use App\Domain\Event\Service\EventFinder;
use App\Factory\LoggerFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

#[CoversClass(EventFinder::class)]
#[CoversMethod(EventFinder::class, 'findLatestPublishedEvents')]
#[UsesClass(Event::class)]
#[UsesClass(EventCollection::class)]
final class EventFinderTest extends TestCase
{
    private function makeLoggerFactoryMock(LoggerInterface $logger): LoggerFactory
    {
        $loggerFactory = $this->createMock(LoggerFactory::class);

        $loggerFactory
            ->method('addFileHandler')
            ->with('event-finder-error.log')
            ->willReturn($loggerFactory);

        $loggerFactory
            ->method('createLogger')
            ->willReturn($logger);
        
        return $loggerFactory;
    }

    private function sampleRow(array $override = []): array
    {
        $row = [
            'id' => 1,
            'title' => '  test event ',
            'slug' => 'test-event/test/event',
            'intro' => 'Intro text',
            'content' => 'Full content here.',
            'place' => ' plauen ',
            'event_date' => '2025-01-01 20:00:00',
            'published_at' => '2025-01-01 20:00:00',
            'is_published' => 1,
            'created_at' => '2025-01-01 20:00:00',
            'updated_at' => '2025-01-01 20:00:00'
        ];

        return array_replace($row, $override);
    }

    #[Test]
    public function findAllEventCollections(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(EventFinderRepository::class);
        $repository->method('findAll')->willReturn([
            $this->sampleRow(['id' => 1, 'title' => 'Example 1']),
            $this->sampleRow(['id' => 2, 'title' => 'Example 2']),
            $this->sampleRow(['id' => 3, 'title' => 'Example 3']),
            $this->sampleRow(['id' => 4, 'title' => 'Example 4']),
        ]);

        $service = new EventFinder($loggerFactory, $repository);

        $events = $service->findAll();

        $this->assertInstanceOf(EventCollection::class, $events);
        $this->assertCount(4, $events);
    }

    #[Test]
    public function findLatestPublishedEvents(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $limit = 5;

        $repository = $this->createMock(EventFinderRepository::class);
        $repository->expects($this->once())
            ->method('findLatestPublishedEvents')
            ->with($limit)
            ->willReturn([
                $this->sampleRow(['id' => 1, 'title' => 'Example 1']),
                $this->sampleRow(['id' => 2, 'title' => 'Example 2']),
                $this->sampleRow(['id' => 3, 'title' => 'Example 3']),
                $this->sampleRow(['id' => 4, 'title' => 'Example 4']),
                $this->sampleRow(['id' => 5, 'title' => 'Example 5']),
            ]);

        $service = new EventFinder($loggerFactory, $repository);

        $events = $service->findLatestPublishedEvents($limit);

        $this->assertCount(5, $events);
    }

    #[Test]
    public function findPublishedEvents(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(EventFinderRepository::class);
        $repository->method('findPublishedEvents')->willReturn([
            $this->sampleRow(['id' => 1, 'title' => 'Example 1']),
            $this->sampleRow(['id' => 2, 'title' => 'Example 2']),
            $this->sampleRow(['id' => 3, 'title' => 'Example 3']),
            $this->sampleRow(['id' => 4, 'title' => 'Example 4']),
            $this->sampleRow(['id' => 5, 'title' => 'Example 5']),
        ]);

        $service = new EventFinder($loggerFactory, $repository);

        $events = $service->findPublishedEvents();

        $this->assertCount(5, $events);
    }

    #[Test]
    public function findAnEventById(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(EventFinderRepository::class);
        $repository->method('findById')
            ->with(1)
            ->willReturn(
                $this->sampleRow([
                    'id' => 1,
                    'event_date' => '2025-05-10T18:30:00+02:00',
                ])
            );
        
        $service = new EventFinder($loggerFactory, $repository);

        $event = $service->findById(1);

        $this->assertInstanceOf(Event::class, $event);
        $this->assertSame(1, $event->getId());
    }
}
