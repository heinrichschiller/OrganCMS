<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use App\Domain\Event\Data\Event;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Types;

final class EventRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function insertEvent(Event $event): int
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('events')
            ->setValue('title', ':title')
            ->setValue('slug', ':slug')
            ->setValue('content', ':content')
            ->setValue('place', ':place')
            ->setValue('event_date', ':event_date')
            ->setValue('published_at', ':published_at')
            ->setValue('is_published', ':is_published')
            ->setValue('created_at', ':created_at')
            ->setValue('updated_at', ':updated_at')
            ->setParameter('title', $event->getTitle())
            ->setParameter('slug', $event->getSlug())
            ->setParameter('content', $event->getContent())
            ->setParameter('place', $event->getPlace())
            ->setParameter('event_date', $event->getEventDate(), Types::DATE_IMMUTABLE)
            ->setParameter('published_at', $event->getPublishedAt(), Types::DATE_IMMUTABLE)
            ->setParameter('is_published', $event->isPublished(), Types::BOOLEAN)
            ->setParameter('created_at', $event->getCreatedAt(), Types::DATE_IMMUTABLE)
            ->setParameter('updated_at', $event->getUpdatedAt(), Types::DATE_IMMUTABLE)
            ->executeStatement();

        return (int) $this->connection->lastInsertId();
    }

    public function update(Event $event): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('events')
            ->set('title', ':title')
            ->set('slug', ':slug')
            ->set('content', ':content')
            ->set('place', ':place')
            ->set('event_date', ':event_date')
            ->set('published_at', ':published_at')
            ->set('is_published', ':is_published')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameter('title', $event->getTitle())
            ->setParameter('slug', $event->getSlug())
            ->setParameter('content', $event->getContent())
            ->setParameter('place', $event->getPlace())
            ->setParameter('event_date', $event->getEventDate(), Types::DATE_IMMUTABLE)
            ->setParameter('published_at', $event->getPublishedAt(), Types::DATE_IMMUTABLE)
            ->setParameter('is_published', $event->isPublished(), Types::BOOLEAN)
            ->setParameter('updated_at', $event->getUpdatedAt(), Types::DATE_IMMUTABLE)
            ->setParameter('id', $event->getId())
            ->executeStatement();
    }

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
