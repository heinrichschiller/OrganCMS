<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Data\EventCollection;
use App\Domain\Event\Repository\EventFinderRepository;
use App\Factory\LoggerFactory;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Throwable;

final class EventFinder
{
    /**
     * @Injection
     * @var EventFinderRepository
     */
    private EventFinderRepository $repository;

    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory
     * @param EventFinderRepository $repository
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        EventFinderRepository $repository
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('event-finder-error.log')
            ->createLogger();

        $this->repository = $repository;
    }

    /**
     * Find all events.
     *
     * @return EventCollection
     */
    public function findAll(): EventCollection
    {
        $events = (array) $this->repository->findAll();

        $collection = new EventCollection;
        foreach ($events as $event) {
            $result = $this->transformDataToEvent($event);

            $collection->add($result);
        }

        return $collection;
    }

    /**
     * Find latest published Events for the homepage.
     *
     * @param int $limit
     *
     * @return EventCollection Collection with all published events.
     */
    public function findLatestPublishedEvents(int $limit): EventCollection
    {
        $eventList = (array) $this->repository->findLatestPublishedEvents($limit);

        $collection = new EventCollection;
        foreach ($eventList as $eventItem) {
            $result = $this->transformDataToEvent($eventItem);

            $collection->add($result);
        }

        return $collection;
    }

    /**
     * Find all published events.
     *
     * @return EventCollection Collection with all published events.
     */
    public function findPublishedEvents(): EventCollection
    {
        $eventList = (array) $this->repository->findPublishedEvents();

        $collection = new EventCollection;
        foreach ($eventList as $eventItem) {
            $result = $this->transformDataToEvent($eventItem);

            $collection->add($result);
        }

        return $collection;
    }

    /**
     * Find an event by id
     *
     * @param int $id Id of an event
     *
     * @return Event
     */
    public function findById(int $id): Event
    {
        $eventItem = (array) $this->repository->findById($id);

        $result = $this->transformDataToEvent($eventItem);

        return $result;
    }

    /**
     * Transform array with event-data to Event object.
     *
     * @param array<mixed> $event Event data.
     *
     * @return Event
     */
    private function transformDataToEvent(array $event): Event
    {
        if (empty($event)) {
            return new Event;
        }

        $event = new Event(
            id: (int) $event['id'],
            title: (string) $event['title'],
            slug: (string) $event['slug'],
            intro: (string) $event['intro'],
            content: (string) $event['content'],
            place: (string) $event['place'],
            eventDate: $this->parseDate($event['event_date']),
            publishedAt: $this->parseDate($event['published_at']),
            isPublished: (bool) $event['is_published'],
            createdAt: $this->parseDate($event['created_at']),
            updatedAt: $this->parseDate($event['updated_at'])
        );

        return $event;
    }

    /**
     * Parse date.
     *
     * @param null|string $date Date
     *
     * @return null|DateTimeImmutable
     */
    private function parseDate(?string $date): ?DateTimeImmutable
    {
        if ($date === null || $date === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($date);
        } catch (Throwable $t) {
            $this->logger->warning(
                'Invalid date in EventFinder',
                ['value' => $date, 'exception' => $t]
            );

            return null;
        }
    }
}
