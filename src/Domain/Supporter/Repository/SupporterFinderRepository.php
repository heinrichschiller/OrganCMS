<?php

declare (strict_types=1);

namespace App\Domain\Supporter\Repository;

use App\Domain\Supporter\Supporter;
use App\Domain\Supporter\SupporterCollection;
use PDO;

final class SupporterFinderRepository
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
     * Find all supporter.
     *
     * @return SupporterCollection
     */
    public function findAll(): SupporterCollection
    {
        $sql = <<<SQL
            SELECT id
                , name
                , is_published
                , published_at
                , created_at
                , updated_at
                FROM supporters
        SQL;

        $stmt = $this->pdo->query($sql);

        $collection = new SupporterCollection;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $supporter = new Supporter(
                $row['id'],
                $row['name'],
                (bool) $row['is_published'],
                $row['published_at'],
                $row['created_at'],
                (string) $row['updated_at']
            );

            $collection->add($supporter);
        }

        return $collection;
    }

    /**
     * Find all public supporter
     *
     * @return SupporterCollection
     */
    public function findAllPublicSupporter(): SupporterCollection
    {
        $sql = <<<SQL
            SELECT id
                , name
                , is_published
                , published_at
                , created_at
                , updated_at
                FROM supporters
                WHERE is_published = 1
        SQL;

        $stmt = $this->pdo->query($sql);

        $collection = new SupporterCollection;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $supporter = new Supporter(
                $row['id'],
                $row['name'],
                (bool) $row['is_published'],
                $row['published_at'],
                $row['created_at'],
                (string) $row['updated_at']
            );

            $collection->add($supporter);
        }

        return $collection;
    }

    /**
     * Find a supporter by id.
     *
     * @param int $id Id of supporter.
     *
     * @return Supporter
     */
    public function findById(int $id): Supporter
    {
        $sql = <<<SQL
            SELECT id
                , name
                , is_published
                , published_at
                , created_at
                , updated_at
                FROM supporters
                WHERE id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $supporter = null;
        if (false !== $row) {
            $supporter = new Supporter(
                $row['id'],
                $row['name'],
                (bool) $row['is_published'],
                $row['published_at'],
                $row['created_at'],
                $row['updated_at']
            );
        }

        return $supporter;
    }
}
