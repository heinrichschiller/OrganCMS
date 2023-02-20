<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\User;
use Doctrine\DBAL\Connection;

final class UserUpdaterRepository
{
    /**
     * @Injection
     * @var Connection
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
     * User update
     *
     * @param User $user User.
     */
    public function update(User $user): void
    {
        $pwHash = password_hash($user->getPassword(), PASSWORD_DEFAULT);

        $this->connection
            ->createQueryBuilder()
            ->update('users')
            ->set('password', ':password')
            ->where('username = :username')
            ->setParameter('password', $pwHash)
            ->setParameter('username', $user->getUsername())
            ->executeQuery();
    }
}
