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
use App\Domain\Donation\Sound;

final class SoundFinderRepository
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
     * Find all sounds by work name and register name
     * 
     * @param string $work
     * @param string $register
     * 
     * @return array<Sound> $items
     */
    public function findAllBy(string $work, string $register): array
    {
        $sql = <<<SQL
            SELECT s.id
                , s.name
                FROM organpipes o
                LEFT JOIN register_sound rs ON rs.id = o.id
                LEFT JOIN register r ON r.id = rs.register_id  
                LEFT JOIN register_work rw ON rw.register_id = r.id
                LEFT JOIN work w ON rw.work_id = w.id
                LEFT JOIN sound s ON s.id = rs.sound_id
                LEFT JOIN sponsorship ss ON ss.id = o.sponsorship_id 
                WHERE w.name = :work AND r.name = :register AND ss.name IS NOT 'vergeben'
                    AND w.name= :work AND r.name = :register AND ss.name IS NOT 'reserviert'
        SQL;

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':work', $work);
        $stmt->bindParam(':register', $register);
        $stmt->execute();

        $items  = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $row;
        }

        return $items;
    }
}