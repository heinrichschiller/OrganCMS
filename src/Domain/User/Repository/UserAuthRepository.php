<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Data\User;
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
     * @param string $identity      User identifier (username, email, etc)
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

    /**
     * Get user object
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
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
