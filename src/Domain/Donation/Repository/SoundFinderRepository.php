<?php

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
                , o.price
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
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $row;
        }

        return $items;
    }
}
