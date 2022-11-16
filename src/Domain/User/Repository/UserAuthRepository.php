<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\User;
use PDO;

final class UserAuthRepository
{
    /**
     * @var bool
     */
    private bool $isAuth = false;

    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @Injection
     * @var User
     */
    private User $user;

    /**
     * The constructor
     *
     * @param PDO $pdo
     * @param User $user
     */
    public function __construct(PDO $pdo, User $user)
    {
        $this->pdo = $pdo;
        $this->user = $user;
    }

    /**
     * Authenticate user
     *
     * @param string $identify      User identifier (username, email, etc)
     * @param string $credentials   User password
     */
    public function authenticate(string $identity, string $credentials): void
    {
        $sql = <<<SQL
            SELECT username,
                password
                FROM users
                WHERE username LIKE :identity 
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':identity', $identity);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (null !== $credentials
            && false !== $result
            && password_verify($credentials, $result['password'])
        ) {
            $this->user->setUsername($result['username']);

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
