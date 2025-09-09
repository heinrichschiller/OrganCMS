<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Data\User;
use Doctrine\DBAL\Connection;

final class UserRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The contructor.
     *
     * @param Connection $connection Doctrine DBAL connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Insert user entry.
     *
     * @param User $user User object
     *
     * @return void
     */
    public function insertUser(User $user): void
    {
        $this->connection
            ->createQueryBuilder()
            ->setValue('first_name', '?')
            ->setValue('given_name', '?')
            ->setValue('username', '?')
            ->setValue('email', '?')
            ->setValue('password', '?')
            ->setValue('is_active', '?')
            ->setValue('created_at', '?')
            ->setValue('updated_at', '?')
            ->setParameter(0, $user->getFirstName())
            ->setParameter(1, $user->getGivenName())
            ->setParameter(2, $user->getUsername())
            ->setParameter(3, $user->getEmail())
            ->setParameter(4, $user->getPassword())
            ->setParameter(5, $user->isActive())
            ->setParameter(6, $user->getCreatedAt())
            ->setParameter(7, $user->getUpdatedAt())
            ->executeQuery();
    }
}
