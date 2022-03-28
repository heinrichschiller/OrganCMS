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
