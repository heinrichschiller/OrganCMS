<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Event;
use App\Domain\Event\EventCollection;
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
    public function findAll(): EventCollection|null
    {
        try {
            $eventList = $this->repository->findAll();

            if (!empty($eventList)) {
                $collection = new EventCollection;
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

                return $collection;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findAll(): %s", $e->getMessage()));
            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findAll(): %s", $e->getMessage()));
            return null;
        }
    }

    /**
     * Find all mainpage events.
     *
     * @param int $limit
     *
     * @return EventCollection|null Collection with all published events.
     */
    public function findAllMainpageEvents(int $limit): EventCollection|null
    {
        try {
            $eventList = $this->repository->findAllMainpageEvents($limit);

            if (!empty($eventList)) {
                $collection = new EventCollection;
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

                return $collection;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return null;
        }
    }

    /**
     * Find all published events.
     *
     * @return EventCollection|null Collection with all published events.
     */
    public function findPublishedEvents(): EventCollection|null
    {
        try {
            $eventList = $this->repository->findPublishedEvents();

            if (!empty($eventList)) {
                $collection = new EventCollection;
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

                return $collection;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return null;
        }
    }

    /**
     * Find an event by id
     *
     * @param int $id Id of an event
     *
     * @return Event|null
     */
    public function findById(int $id): Event|null
    {
        try {
            $eventItem = $this->repository->findById($id);

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

                return $event;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->findPublishedEvents(): %s", $e->getMessage()));

            return null;
        }
    }
}
