<?php

declare(strict_types=1);

namespace App\Domain\Event\Repository;

use Doctrine\DBAL\Connection;

final class EventFinderRepository
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @return array<mixed>
     */
    public function findAll(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'place',
                'event_date',
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
     * @return array<mixed>
     */
    public function findLatestPublishedEvents(int $limit): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'place',
                'event_date',
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
     * @return array<mixed>
     */
    public function findPublishedEvents(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'place',
                'event_date',
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
     * @return array<mixed>
     */
    public function findById(int $id): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'place',
                'event_date',
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

    /**
     * @return array<mixed>
     */
    public function findByName(string $name): array
    {
        return $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'place',
                'event_date',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('events')
            ->where('title = :title')
            ->setParameter('title', $name)
            ->executeQuery()
            ->fetchAssociative() ?: [];
    }
}
