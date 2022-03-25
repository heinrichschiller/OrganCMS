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

        if(null !== $credentials && password_verify($credentials, $result['password'])) {
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