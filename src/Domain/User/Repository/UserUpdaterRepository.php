<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Data\User;
use Doctrine\DBAL\Connection;

final class UserUpdaterRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function update(User $user): void
    {
        $pwHash = password_hash((string) $user->getPassword(), PASSWORD_DEFAULT);

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
