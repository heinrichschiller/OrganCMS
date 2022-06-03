<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use App\Domain\Event\Event;
use PDO;

final class EventUpdaterRepository
{
    /**
     * @Injection
     * var PDO
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
     * Update event data
     * 
     * @param array<mixed> $formData The form data
     */
    public function update(Event $event): void
    {
        $sql = <<<SQL
            UPDATE events
            SET title = :title,
                place = :place,
                description = :description,
                event_date = :event_date,
                published = :published,
                published_on = :published_on
                WHERE id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $event->getId());
        $stmt->bindParam(':title', $event->getTitle());
        $stmt->bindParam(':place', $event->getPlace());
        $stmt->bindParam(':description', $event->getDesc());
        $stmt->bindParam(':event_date', $event->getEventDate());
        $stmt->bindParam(':published', $event->isPublished());
        $stmt->bindParam(':published_on', $event->getPublishedOn());

        $stmt->execute();
    }
}
