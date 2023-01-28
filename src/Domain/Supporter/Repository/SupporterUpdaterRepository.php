<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Repository;

use PDO;

final class SupporterUpdaterRepository
{
    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    /**
     * The constructor.
     * 
     * @param PDO $pdo PDO connection.
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function update(array $formData)
    {
        $sql = <<<SQL
            UPDATE supporters
                SET name = :name,
                    is_published = :is_published,
                    updated_at = :updated_at
                    WHERE id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':name', $formData['name']);
        $stmt->bindParam(':is_published', $formData['publish']);
        $stmt->bindParam(':updated_at', date("d.m.Y H:i:s"));
        $stmt->bindParam(':id', $formData['id']);

        $stmt->execute();
    }
}
