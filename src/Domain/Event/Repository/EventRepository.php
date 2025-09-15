<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use App\Domain\Event\Data\Event;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Types;

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
     * Insert an event entry into database table.
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
            ->setValue('slug', '?')
            ->setValue('intro', '?')
            ->setValue('content', '?')
            ->setValue('place', '?')
            ->setValue('event_date', '?')
            ->setValue('on_mainpage', '?')
            ->setValue('published_at', '?')
            ->setValue('is_published', '?')
            ->setValue('created_at', '?')
            ->setValue('updated_at', '?')
            ->setParameter(0, $event->getTitle())
            ->setParameter(1, $event->getSlug())
            ->setParameter(2, $event->getIntro())
            ->setParameter(3, $event->getContent())
            ->setParameter(4, $event->getPlace())
            ->setParameter(5, $event->getEventDate(), Types::DATE_IMMUTABLE)
            ->setParameter(6, $event->getOnMainpage(), Types::BOOLEAN)
            ->setParameter(7, $event->getPublishedAt(), Types::DATE_IMMUTABLE)
            ->setParameter(8, $event->isPublished(), Types::BOOLEAN)
            ->setParameter(9, $event->getCreatedAt(), Types::DATE_IMMUTABLE)
            ->setParameter(10, $event->getUpdatedAt(), Types::DATE_IMMUTABLE)
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
            ->setValue('title', '?')
            ->setValue('slug', '?')
            ->setValue('intro', '?')
            ->setValue('content', '?')
            ->setValue('place', '?')
            ->setValue('event_date', '?')
            ->setValue('on_mainpage', '?')
            ->setValue('published_at', '?')
            ->setValue('is_published', '?')
            ->setValue('created_at', '?')
            ->setValue('updated_at', '?')
            ->where('id = :id')
            ->setParameter(0, $event->getTitle())
            ->setParameter(1, $event->getSlug())
            ->setParameter(2, $event->getIntro())
            ->setParameter(3, $event->getContent())
            ->setParameter(4, $event->getPlace())
            ->setParameter(5, $event->getEventDate(), Types::DATE_IMMUTABLE)
            ->setParameter(6, $event->getOnMainpage(), Types::BOOLEAN)
            ->setParameter(7, $event->getPublishedAt(), Types::DATE_IMMUTABLE)
            ->setParameter(8, $event->isPublished(), Types::BOOLEAN)
            ->setParameter(9, $event->getCreatedAt(), Types::DATE_IMMUTABLE)
            ->setParameter(10, $event->getUpdatedAt(), Types::DATE_IMMUTABLE)
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
