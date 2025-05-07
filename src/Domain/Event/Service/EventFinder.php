<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Data\EventCollection;
use App\Domain\Event\Repository\EventFinderRepository;
use App\Factory\LoggerFactory;
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
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
    }

    /**
     * Find all events.
     *
     * @return EventCollection
     */
    public function findAll(): EventCollection
    {
        try {
            $eventList = (array) $this->repository->findAll();
            $collection = new EventCollection;

            if (!empty($eventList)) {
                foreach ($eventList as $eventItem) {
                    $event = new Event(
                        (int) $eventItem['id'],
                        $eventItem['title'],
                        $eventItem['place'],
                        $eventItem['description'],
                        $eventItem['event_date'],
                        (bool) $eventItem['published'],
                        $eventItem['published_on'],
                        $eventItem['created_at']
                    );

                    $collection->add($event);
                }
            }

            return $collection;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findAll(): %s", $e->getMessage()));
            return new EventCollection;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findAll(): %s", $e->getMessage()));
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
                    $event = new Event(
                        (int) $eventItem['id'],
                        $eventItem['title'],
                        $eventItem['place'],
                        $eventItem['description'],
                        $eventItem['event_date'],
                        (bool) $eventItem['published'],
                        $eventItem['published_on'],
                        $eventItem['created_at']
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
                    $event = new Event(
                        (int) $eventItem['id'],
                        $eventItem['title'],
                        $eventItem['place'],
                        $eventItem['description'],
                        $eventItem['event_date'],
                        (bool) $eventItem['published'],
                        $eventItem['published_on'],
                        $eventItem['created_at']
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
    public function findById(int $id): Event
    {
        try {
            $eventItem = (array) $this->repository->findById($id);

            if (!empty($eventItem)) {
                $event = new Event(
                    $eventItem['id'],
                    $eventItem['title'],
                    $eventItem['place'],
                    $eventItem['description'],
                    $eventItem['event_date'],
                    (bool)$eventItem['published'],
                    $eventItem['published_on'],
                    $eventItem['created_at']
                );
            }

            return $event;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return new Event;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return new Event;
        }
    }
}
