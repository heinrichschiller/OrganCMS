<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use App\Domain\Event\Event;
use PDO;

final class EventFinderRepository
{
    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    /**
     * The constructor.
     * 
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Find all events
     * 
     * @return array<Event>
     */
    public function findAll(): array
    {
        $sql = <<<SQL
            SELECT id,
                title,
                place,
                description,
                event_date,
                created_at,
                published,
                published_on
                FROM events
                    ORDER BY event_date ASC
        SQL;

        $stmt = $this->pdo->query($sql);

        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new Event;

            $event->setId($row['id']);
            $event->setTitle($row['title']);
            $event->setPlace($row['place']);
            $event->setDesc($row['description']);
            $event->setEventDate($row['event_date']);
            $event->setPublished((bool)$row['published']);
            $event->setPublishedOn($row['published_on']);

            $events[] = $event;
        }

        return $events;
    }

    /**
     * Find all published events
     * 
     * @return array<Event>
     */
    public function findPublishedEvents(): array
    {
        $sql = <<<SQL
            SELECT id,
                title,
                place,
                description,
                event_date,
                created_at,
                published,
                published_on
                FROM events
                WHERE published = 1
                    ORDER BY event_date ASC
        SQL;

        $stmt = $this->pdo->query($sql);

        $events = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $event = new Event;

            $event->setId($row['id']);
            $event->setTitle($row['title']);
            $event->setPlace($row['place']);
            $event->setDesc($row['description']);
            $event->setEventDate($row['event_date']);
            $event->setPublished((bool)$row['published']);
            $event->setPublishedOn($row['published_on']);

            $events[] = $event;
        }

        return $events;
    }

    /**
     * Find an event by event id.
     * 
     * @param int $id   Event id
     * 
     * @return Event
     */
    public function whereId(int $id): Event
    {
        $sql = <<<SQL
            SELECT id,
                title,
                place,
                description,
                event_date,
                created_at,
                published,
                published_on
                FROM events
                WHERE id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $event = new Event;

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $event->setId($row['id']);
        $event->setTitle($row['title']);
        $event->setPlace($row['place']);
        $event->setDesc($row['description']);
        $event->setEventDate($row['event_date']);
        $event->setPublished((bool)$row['published']);
        $event->setPublishedOn($row['published_on']);

        return $event;
    }
}
