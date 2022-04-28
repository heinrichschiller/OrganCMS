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

namespace App\Domain\Donation\Repository;

use PDO;
use App\Domain\Donation\Register;

final class RegisterFinderRepository
{
    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    /**
     * The constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Find all register
     *
     * @return array<Register>
     */
    public function findAll(string $register): array
    {
        $sql = <<<SQL
            SELECT rw.id
                , r.name
            FROM register_work as rw
            LEFT JOIN register as r ON r.id = rw.register_id
            LEFT JOIN work as w ON w.id = rw.work_id
            WHERE w.name = :register
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':register', $register);
        $stmt->execute();

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new Register(...$row);
        }

        return $items;
    }
}
