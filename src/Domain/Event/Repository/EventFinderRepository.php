<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use Doctrine\DBAL\Connection;

final class EventFinderRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Find all events
     *
     * @return array
     */
    public function findAllOrFail(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'intro',
                'content',
                'place',
                'event_date',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('events')
            ->orderBy('event_date', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];

        return $result;
    }

    /**
     * Find all mainpage events
     *
     * @param int $limit
     *
     * @return array
     */
    public function findAllMainpageEvents(int $limit): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'intro',
                'content',
                'place',
                'event_date',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('events')
            ->where('is_published = 1')
            ->orderBy('event_date', 'ASC')
            ->setMaxResults($limit)
            ->executeQuery()
            ->fetchAllAssociative() ?: [];
        
        return $result;
    }

    /**
     * Find all published events
     *
     * @return array
     */
    public function findPublishedEvents(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'intro',
                'content',
                'place',
                'event_date',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('events')
            ->where('is_published = 1')
            ->orderBy('event_date', 'ASC')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];
        
        return $result;
    }

    /**
     * Find an event by event id.
     *
     * @param int $id Event id
     *
     * @return array
     */
    public function findByIdOrFail(int $id): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'intro',
                'content',
                'place',
                'event_date',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('events')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery()
            ->fetchAssociative() ?: [];

        return $result;
    }
}
