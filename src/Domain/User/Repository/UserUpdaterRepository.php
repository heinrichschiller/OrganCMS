<?php

/**
 * MIT License
 *
 * Copyright (c) 2022 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

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
