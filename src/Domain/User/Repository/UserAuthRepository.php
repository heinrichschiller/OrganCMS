<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\User;
use Doctrine\DBAL\Connection;

final class UserAuthRepository
{
    /**
     * @var bool
     */
    private bool $isAuth = false;

    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * @Injection
     * @var User
     */
    private User $user;

    /**
     * The constructor
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Authenticate user
     *
     * @param string $identify      User identifier (username, email, etc)
     * @param string $credentials   User password
     */
    public function authenticate(string $identity, string $credentials): void
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('id', 'first_name', 'given_name', 'username', 'email', 'password')
            ->from('users')
            ->where('username LIKE ?')
            ->setParameter(0, $identity)
            ->executeQuery()
            ->fetchAssociative() ?: [];

        if (null !== $credentials
            && false !== $result
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

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->user->getUsername();
    }
    
    /**
     * Return user authentication
     *
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->isAuth;
    }
}
