<?php

declare(strict_types=1);

namespace App\Domain\Donation\Repository;

use App\Domain\Donation\Work;
use PDO;

class WorkFinderRepository
{
    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    /**
     * The constructor
     *
     * @param PDO $pdo
     * @param Work $work
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Find all organ works.
     *
     * @return array<Work>
     */
    public function findAll(): array
    {
        $sql = <<<SQL
            SELECT id
                , name
                FROM work
        SQL;

        $items = [];
        foreach ($this->pdo->query($sql, PDO::FETCH_ASSOC) as $row) {
            $items[] = new Work(...$row);
        }

        return $items;
    }
}
