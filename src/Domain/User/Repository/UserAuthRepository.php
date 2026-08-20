<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Data\User;
use Doctrine\DBAL\Connection;

final class UserAuthRepository
{
    private bool $isAuth = false;
    private Connection $connection;
    private User $user;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function authenticate(string $identity, string $credentials): void
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'first_name',
                'given_name',
                'username',
                'email',
                'password'
            )
            ->from('users')
            ->where('username LIKE ?')
            ->setParameter(0, $identity)
            ->executeQuery()
            ->fetchAssociative() ?: [];

        if ($credentials !== null
            && $result !== false
            && password_verify($credentials, $result['password'])
        ) {
            $this->user = new User(
                (int) $result['id'],
                $result['first_name'],
                $result['given_name'],
                $result['username'],
                $result['email'],
                $result['password']
            );

            $this->isAuth = true;
        }
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function isAuth(): bool
    {
        return $this->isAuth;
    }
}
