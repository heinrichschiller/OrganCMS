<?php

declare (strict_types=1);

namespace App\Domain\Supporter\Repository;

use Doctrine\DBAL\Connection;

final class SupporterFinderRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The constructor
     *
     * @param Connection $connection Doctrine DBAL connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Find all supporter.
     *
     * @return array
     */
    public function findAll(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('id', 'name', 'is_published', 'published_at', 'created_at', 'updated_at')
            ->from('supporters')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];

        return $result;
    }

    /**
     * Find all public supporter
     *
     * @return array
     */
    public function findAllPublicSupporter(): array
    {
        $result =  $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'name',
                'is_published',
                'published_at',
                'created_at',
                'updated_at'
            )
            ->from('supporters')
            ->where('is_published = 1')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];

        return $result;
    }

    /**
     * Find a supporter by id.
     *
     * @param int $id Id of supporter.
     *
     * @return array
     */
    public function findById(int $id): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('id', 'name', 'is_published', 'published_at', 'created_at', 'updated_at')
            ->from('supporters')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery()
            ->fetchAssociative() ?: [];
        
        return $result;
    }
}
