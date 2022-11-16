<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use App\Domain\Event\Event;
use PDO;

final class EventCreatorRepository
{
    /**
     * @var int
     */
    private int $lastInsertId = 0;

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
     * Create an event entry.
     *
     * @param Event $event
     */
    public function create(Event $event): void
    {
        $this->insertIntoEvents($event);
        $this->insertEventCategories();
    }

    /**
     * Insert into events
     *
     * @param Event event
     */
    public function insertIntoEvents(Event $event): void
    {
        $sql = <<<SQL
            INSERT INTO events (title, place, description, event_date, created_at, published, published_on)
            VALUES (:title, :place, :desc, :event_date, :created_at, :published, :publishedOn)
        SQL;

        $stmt = $this->pdo->prepare($sql);
// dd($event);
        $stmt->bindParam(':title', $event->getTitle());
        $stmt->bindParam(':place', $event->getPlace());
        $stmt->bindParam(':desc', $event->getDesc());
        $stmt->bindParam(':event_date', $event->getEventDate());
        $stmt->bindParam(':created_at', date('Y-m-d'));
        $stmt->bindParam(':published', $event->isPublished());
        $stmt->bindParam(':published_on', $event->getPublishedOn());
        

        $stmt->execute();

        $this->lastInsertId = (int) $this->pdo->lastInsertId();
    }

    /**
     * Insert event categories.
     */
    public function insertEventCategories(): void
    {
        $sql = <<<SQL
            INSERT INTO event_category (event_id, category_id)
            VALUES (:lastId, 1)
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':lastId', $this->lastInsertId);
        $stmt->execute();
    }
}
