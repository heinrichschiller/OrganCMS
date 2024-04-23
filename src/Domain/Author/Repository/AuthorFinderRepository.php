<?php

declare(strict_types=1);

namespace App\Domain\Author\Repository;

use Doctrine\DBAL\Connection;

final class AuthorFinderRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * @param Connection Doctrine DBAL Connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Find a author by id.
     * 
     * @param int $id Author id.
     * 
     * @return array<mixed>
     */
    public function findByIdOrFail(int $id): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'a.id',
                'user_id',
                'author_name'
            )
            ->from('authors', 'a')
            ->leftJoin('a', 'users', 'u')
            ->where('a.id = ?')
            ->setParameter(0, $id)
            ->executeQuery()
            ->fetchAssociative() ?: [];
        
        return $result;
    }
}
