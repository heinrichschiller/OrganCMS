<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Data\EventCollection;
use App\Domain\Event\Repository\EventFinderRepository;
use App\Factory\LoggerFactory;
use DateTimeImmutable;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

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
    public function __construct(LoggerFactory $loggerFactory, EventFinderRepository $repository)
    {
        $this->logger = $loggerFactory->addFileHandler('event-finder-error.log')->createLogger();
        $this->repository = $repository;
    }

    /**
     * Find all events.
     *
     * @return EventCollection
     */
    public function findAllOrFail(): EventCollection
    {
        try {
            $eventItems = (array) $this->repository->findAllOrFail();
            $collection = new EventCollection;

            if (!empty($eventItems)) {
                foreach ($eventItems as $item) {
                    $eventDate = new DateTimeImmutable($item['event_date']);

                    if ($item['published_at'] === null || $item['published_at'] === '') {
                        $publishedAt = null;
                    } else {
                        $publishedAt = new DateTimeImmutable($item['published_at']);
                    }
                    
                    $createdAt = new DateTimeImmutable($item['created_at']);

                    $event = new Event(
                        id: (int) $item['id'],
                        title: $item['title'],
                        place: $item['place'],
                        content: $item['content'],
                        eventDate: $eventDate,
                        isPublished: (bool) $item['is_published'],
                        publishedAt: $publishedAt,
                        createdAt: $createdAt
                    );

                    $collection->add($event);
                }
            }

            return $collection;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findAllOrFail(): %s", $e->getMessage()));
            return new EventCollection;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findAllOrFail(): %s", $e->getMessage()));
            return new EventCollection;
        }
    }

    /**
     * Find all mainpage events.
     *
     * @param int $limit
     *
     * @return EventCollection Collection with all published events.
     */
    public function findAllMainpageEvents(int $limit): EventCollection
    {
        try {
            $eventList = (array) $this->repository->findAllMainpageEvents($limit);
            $collection = new EventCollection;

            if (!empty($eventList)) {
                foreach ($eventList as $eventItem) {
                    $eventDate = null;
                    if ($eventItem['event_date'] !== null && $eventItem['event_date'] !== '') {
                        $eventDate = new DateTimeImmutable($eventItem['event_date']);
                    }

                    $publishedAt = null;
                    if ($eventItem['published_at'] !== null && $eventItem['published_at'] !== '') {
                        $publishedAt = new DateTimeImmutable($eventItem['published_at']);
                    }

                    $createdAt = null;
                    if ($eventItem['created_at'] !== null && $eventItem['created_at'] !== '') {
                        $createdAt = new DateTimeImmutable($eventItem['created_at']);
                    }

                    $event = new Event(
                        id: (int) $eventItem['id'],
                        title: $eventItem['title'],
                        place: $eventItem['place'],
                        content: $eventItem['content'],
                        eventDate: $eventDate,
                        isPublished: (bool) $eventItem['is_published'],
                        publishedAt: $publishedAt,
                        createdAt: $createdAt
                    );

                    $collection->add($event);
                }
            }

            return $collection;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return new EventCollection;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return new EventCollection;
        }
    }

    /**
     * Find all published events.
     *
     * @return EventCollection Collection with all published events.
     */
    public function findPublishedEvents(): EventCollection
    {
        try {
            $eventList = (array) $this->repository->findPublishedEvents();
            $collection = new EventCollection;

            if (!empty($eventList)) {
                foreach ($eventList as $eventItem) {
                    $eventDate = null;
                    if ($eventItem['event_date'] !== null && $eventItem['event_date'] !== '') {
                        $eventDate = new DateTimeImmutable($eventItem['event_date']);
                    }

                    $publishedAt = null;
                    if ($eventItem['published_at'] !== null && $eventItem['published_at'] !== '') {
                        $publishedAt = new DateTimeImmutable($eventItem['published_at']);
                    }

                    $createdAt = null;
                    if ($eventItem['created_at'] !== null && $eventItem['created_at'] !== '') {
                        $createdAt = new DateTimeImmutable($eventItem['created_at']);
                    }

                    $event = new Event(
                        id: (int) $eventItem['id'],
                        title: $eventItem['title'],
                        place: $eventItem['place'],
                        content: $eventItem['content'],
                        eventDate: $eventDate,
                        isPublished: (bool) $eventItem['is_published'],
                        publishedAt: $publishedAt,
                        createdAt: $createdAt
                    );

                    $collection->add($event);
                }
            }

            return $collection;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return new EventCollection;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return new EventCollection;
        }
    }

    /**
     * Find an event by id
     *
     * @param int $id Id of an event
     *
     * @return Event
     */
    public function findByIdOrFail(int $id): Event
    {
        try {
            $eventItem = (array) $this->repository->findByIdOrFail($id);

            $eventDate = null;
            if ($eventItem['event_date'] !== null && $eventItem['event_date'] !== '') {
                $eventDate = new DateTimeImmutable($eventItem['event_date']);
            }

            $publishedAt = null;
            if ($eventItem['published_at'] !== null && $eventItem['published_at'] !== '') {
                $publishedAt = new DateTimeImmutable($eventItem['published_at']);
            }

            $createdAt = null;
            if ($eventItem['created_at'] !== null && $eventItem['created_at'] !== '') {
                $createdAt = new DateTimeImmutable($eventItem['created_at']);
            }

            $updatedAt = null;
            if ($eventItem['updated_at'] !== null && $eventItem['updated_at'] !== '') {
                $updatedAt = new DateTimeImmutable($eventItem['updated_at']);
            }

            if (!empty($eventItem)) {
                $event = new Event(
                    id: $eventItem['id'],
                    title: $eventItem['title'],
                    slug: $eventItem['slug'],
                    intro: $eventItem['intro'],
                    content: $eventItem['content'],
                    place: $eventItem['place'],
                    eventDate: $eventDate,
                    publishedAt: $publishedAt,
                    isPublished: (bool) $eventItem['is_published'],
                    createdAt: $createdAt,
                    updatedAt: $updatedAt
                );
            }

            return $event;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findByIdOrFail(): %s", $e->getMessage()));

            return new Event;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findByIdOrFail(): %s", $e->getMessage()));

            return new Event;
        }
    }
}
