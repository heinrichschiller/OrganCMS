<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use App\Domain\Event\Data\Event;
use Doctrine\DBAL\Connection;

final class EventUpdaterRepository
{
    /**
     * @Injection
     * var Connection
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
}
