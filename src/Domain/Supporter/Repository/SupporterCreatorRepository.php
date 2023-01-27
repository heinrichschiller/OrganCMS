<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Repository;

use App\Domain\Supporter\Supporter;
use PDO;

final class SupporterCreatorRepository
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
    
    /**
     * Insert new supporter
     *
     * @param Supporter $supporter  Supporter
     */
    public function insert(Supporter $supporter): int
    {
        $sql = <<<SQL
            INSERT INTO supporters 
            (
                name, is_published, published_at, created_at, updated_at
            )
            VALUES 
            (
                :name, :is_published, :published_at, :created_at, :updated_at
            )
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':name', $supporter->getName());
        $stmt->bindParam(':is_published', $supporter->isPublished());
        $stmt->bindParam(':published_at', $supporter->getPublishedAt());
        $stmt->bindParam(':created_at', $supporter->getCreatedAt());
        $stmt->bindParam(':published_at', $supporter->getPublishedAt());

        $stmt->execute();

        return (int) $this->pdo->lastInsertId();
    }
}
