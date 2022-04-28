<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\User;
use PDO;

final class UserReaderRepository
{
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
     * The contructor
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
     * Get user by username
     *
     * @param string $username
     *
     * @return User
     */
    public function getByUsername(string $username): User
    {
        $sql = <<<SQL
            SELECT id, 
                first_name, 
                given_name, 
                username,
                email
            FROM users
            WHERE username LIKE :username
        SQL;
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->user->setId((int) $result['id']);
        $this->user->setFirstName((string) $result['first_name']);
        $this->user->setGivenName((string) $result['given_name']);
        $this->user->setUsername((string) $result['username']);
        $this->user->setEmail((string) $result['email']);

        return $this->user;
    }
}
