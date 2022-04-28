<?php

declare(strict_types=1);

namespace App\Domain\Donation\Repository;

use App\Domain\Donation\DonationBoard;
use PDO;

final class DonationBoardReaderRepository
{
    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    /**
     * @Injection
     * @var DonationBoard
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
     * Read donation table
     *
     * @return DonationBoard
     */
    public function read(): DonationBoard
    {
        $sql = <<<SQL
            SELECT total,
                date,
                user
                FROM donation
        SQL;

        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->donation->setTotal($result['total']);
        $this->donation->setDate($result['date']);
        $this->donation->setUser($result['user']);

        return $this->donation;
    }
}
