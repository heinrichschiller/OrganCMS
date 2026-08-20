<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Data\EventCollection;
use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\Event\Repository\EventFinderRepository;
use App\Domain\Exception\DomainRecordNotFoundException;
use DateTimeImmutable;

final class EventFinder
{
    public function __construct(
        private EventFinderRepository $repository
    ) {
    }

    public function findAll(): EventCollection
    {
        $eventList = (array) $this->repository->findAll();

        if ($eventList === []) {
            throw new DomainRecordNotFoundException();
        }

        $collection = new EventCollection;
        foreach ($eventList as $eventItem) {
            $event = $this->transformDataToEvent($eventItem);

            $collection->add($event);
        }

        return $collection;
    }

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
    
    public function findById(int $id): Event
    {
        $data = (array) $this->repository->findById($id);

        if ($data === []) {
            throw new EventNotFoundException($id);
        }

        $event = $this->transformDataToEvent($data);

        return $event;
    }

    /**
     * @param array<mixed> $data Event data.
     */
    private function transformDataToEvent(array $data): Event
    {
        if ($data === []) {
            return new Event();
        }

        return new Event(
            id: (int) $data['id'],
            title: (string) $data['title'],
            slug: (string) $data['slug'],
            content: (string) $data['content'],
            place: (string) $data['place'],
            eventDate: $this->parseDate($data['event_date']),
            publishedAt: $this->parseDate($data['published_at']),
            isPublished: (bool) $data['is_published'],
            createdAt: $this->parseDate($data['created_at']),
            updatedAt: new DateTimeImmutable()
        );
    }

    private function parseDate(?string $date): ?DateTimeImmutable
    {
        if ($date === null || $date === '') {
            return null;
        }

        return new DateTimeImmutable($date);
    }
}
