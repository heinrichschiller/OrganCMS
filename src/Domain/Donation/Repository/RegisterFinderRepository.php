<?php

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
