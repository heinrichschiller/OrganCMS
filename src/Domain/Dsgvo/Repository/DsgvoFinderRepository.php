<?php

declare(strict_types=1);

namespace App\Domain\Dsgvo\Repository;

use Doctrine\DBAL\Connection;

final class DsgvoFinderRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    /**
     * @return array<mixed>
     */
    public function find(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'details',
                'updated_at'
            )
            ->from('dsgvo')
            ->executeQuery()
            ->fetchAssociative() ?: [];

        return $result;
    }
}
