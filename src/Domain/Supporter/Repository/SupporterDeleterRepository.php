<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Repository;

use PDO;

final class SupporterDeleterRepository
{
    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    /**
     * The constructor.
     *
     * @param PDO $pdo PDO connection
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Delete supporter by id.
     *
     * @param int $id Supporter id.
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $sql = <<<SQL
            DELETE FROM supporters
            WHERE id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();
    }
}
