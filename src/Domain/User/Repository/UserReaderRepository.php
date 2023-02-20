<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use Doctrine\DBAL\Connection;

final class UserReaderRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The contructor
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get user by username
     *
     * @param string $username
     *
     * @return array
     */
    public function findByUsername(string $username): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('id', 'first_name', 'given_name', 'username', 'email')
            ->from('users')
            ->where('username = :username')
            ->setParameter('username', $username)
            ->executeQuery()
            ->fetchAssociative() ?: [];

        return $result;
    }
}
