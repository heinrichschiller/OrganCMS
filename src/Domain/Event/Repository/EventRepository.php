<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use App\Domain\Event\Data\Event;
use Doctrine\DBAL\Connection;

final class EventRepository
{
    /**
     * @var int
     */
    private int $lastInsertId;

    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;
    
    /**
     * The constructor.
     *
     * @param Connection $connection Doctrine DBAL connection.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Create an event entry.
     *
     * @param Event $event
     *
     * @return void
     */
    public function createEvent(Event $event): void
    {
        $this->insertEvent($event);
        $this->insertEventCategory();
    }

    /**
     * Insert an event
     *
     * @param Event $event
     *
     * @return void
     */
    public function insertEvent(Event $event): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('events')
            ->setValue('title', '?')
            ->setValue('place', '?')
            ->setValue('description', '?')
            ->setValue('event_date', '?')
            ->setValue('created_at', '?')
            ->setValue('published', '?')
            ->setValue('published_on', '?')
            ->setParameter(0, $event->getTitle())
            ->setParameter(1, $event->getPlace())
            ->setParameter(2, $event->getDesc())
            ->setParameter(3, $event->getEventDate())
            ->setParameter(4, $event->getCreatedAt())
            ->setParameter(5, $event->isPublished())
            ->setParameter(6, $event->getPublishedOn())
            ->executeQuery();

        $this->lastInsertId = (int) $this->connection->lastInsertId();
    }

    /**
     * Insert an event category.
     *
     * @return void
     */
    public function insertEventCategory(): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('event_category')
            ->setValue('event_id', '?')
            ->setValue('category_id', '?')
            ->setParameter(0, $this->lastInsertId)
            ->setParameter(1, 1)
            ->executeQuery();
    }

    /**
     * Update event data
     *
     * @param Event $event Event data object.
     *
     * @return void
     */
    public function update(Event $event): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('events')
            ->set('title', ':title')
            ->set('place', ':place')
            ->set('description', ':description')
            ->set('event_date', ':event_date')
            ->set('published', ':published')
            ->set('published_on', ':published_on')
            ->where('id = :id')
            ->setParameter('title', $event->getTitle())
            ->setParameter('place', $event->getPlace())
            ->setParameter('description', $event->getDesc())
            ->setParameter('event_date', $event->getEventDate())
            ->setParameter('published', $event->isPublished())
            ->setParameter('published_on', $event->getPublishedOn())
            ->setParameter('id', $event->getId())
            ->executeQuery();
    }

    /**
     * Exists event id or not.
     *
     * @param int $eventId Event id.
     *
     * @return bool
     */
    public function existsEventId(int $eventId): bool
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('id')
            ->from('events')
            ->where('id = ?')
            ->setParameter(0, $eventId)
            ->executeQuery();
        
        return (bool) $result;
    }

    /**
     * Delete supporter by id.
     *
     * @param int $id Supporter id.
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('events')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery();
    }
}
