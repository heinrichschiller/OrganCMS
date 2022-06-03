<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Event;
use App\Domain\Event\Repository\EventFinderRepository;

final class EventFinder
{
    /**
     * @Injection
     * @var EventFinderRepository
     */
    private EventFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param EventFinderRepository $repository
     */
    public function __construct(EventFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find all events.
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * Find all published events.
     */
    public function findPublishedEvents(): array
    {
        return $this->repository->findPublishedEvents();
    }

    /**
     * Find an event by id
     *
     * @param int $id Id of an event
     *
     * @return Event
     */
    public function whereId(int $id): Event
    {
        return $this->repository->whereId($id);
    }
}
