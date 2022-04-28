<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\User;
use Exception;
use Monolog\Logger;
use PDO;

final class UserUpdaterRepository
{
    /**
     * @var bool
     */
    private bool $isUpdated = false;

    /**
     * @Injection
     * @var Logger
     */
    private Logger $logger;

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
     * @param Logger $logger
     * @param PDO $pdo
     * @param User $user
     */
    public function __construct(Logger $logger, PDO $pdo, User $user)
    {
        $this->logger = $logger;
        $this->pdo = $pdo;
        $this->user = $user;
    }

    /**
     * User update
     *
     * @param string $identity      User identifier (username, email, etc)
     * @param string $credentials   User password
     */
    public function update(string $identity, string $credentials): void
    {
        $sql = <<<SQL
            UPDATE users
                SET password = :password
                    WHERE username LIKE :username
        SQL;
        
        $this->user->setUsername($identity);
        $this->user->setPassword($credentials);

        $pwHash = password_hash($this->user->getPassword(), PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':username', $this->user->getUsername());
        $stmt->bindParam(':password', $pwHash);

        try {
            $stmt->execute();

            $this->isUpdated = true;
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());

            $this->isUpdated = false;
        }
    }

    /**
     * Return user update status
     *
     * @return bool
     */
    public function isUpdated(): bool
    {
        return $this->isUpdated;
    }
}
