<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use Doctrine\DBAL\Connection;

final class UserReaderRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return array<mixed>
     */
    public function findByUsername(string $username): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'first_name',
                'given_name',
                'username',
                'email'
            )
            ->from('users')
            ->where('username = :username')
            ->setParameter('username', $username)
            ->executeQuery()
            ->fetchAssociative() ?: [];

        return $result;
    }
}
