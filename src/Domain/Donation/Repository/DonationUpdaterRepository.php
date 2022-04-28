<?php

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
