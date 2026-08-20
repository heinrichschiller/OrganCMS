<?php

declare (strict_types=1);

namespace App\Domain\Supporter\Repository;

use Doctrine\DBAL\Connection;

final class SupporterFinderRepository
{
    public function __construct(
        private Connection $connection
    ) {
        $this->connection = $connection;
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
                'name',
                'is_published',
                'published_at',
                'created_at',
                'updated_at'
            )
            ->from('supporters')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];

        return $result;
    }

    /**
     * @return array<mixed>
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
     * @param int $id Id of supporter.
     *
     * @return array<mixed>
     */
    public function findById(int $id): array
    {
        $result = $this->connection
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
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery()
            ->fetchAssociative() ?: [];
        
        return $result;
    }

    public function findByName(string $name)
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('name')
            ->from('supporters')
            ->where('name = ?')
            ->setParameter(0, $name)
            ->executeQuery()
            ->fetchAssociative() ?: [];
        
        return $result;
    }
}
