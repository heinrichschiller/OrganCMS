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

use App\Domain\Donation\DonationBoard;
use PDO;

final class DonationUpdaterRepository
{
    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @Injection
     * @var Donation
     */
    private DonationBoard $donation;

    /**
     * The constructor
     *
     * @param PDO $pdo
     * @param DonationBoard $donation
     */
    public function __construct(PDO $pdo, DonationBoard $donation)
    {
        $this->pdo = $pdo;
        $this->donation = $donation;
    }

    /**
     * Update donation status
     *
     * @param string $total
     * @param string $date
     * @param string $user
     */
    public function update(string $total, string $date, string $user)
    {
        $this->donation->setTotal($total);
        $this->donation->setDate($date);
        $this->donation->setUser($user);

        $sql = <<<SQL
            UPDATE donation
                SET total = :total,
                    date = :date,
                    user = :user
                    WHERE id = 1
        SQL;

        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':total', $this->donation->getTotal());
        $stmt->bindParam(':date', $this->donation->getDate());
        $stmt->bindParam(':user', $this->donation->getUser());
        $stmt->execute();
    }
}
