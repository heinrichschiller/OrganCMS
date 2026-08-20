<?php

declare(strict_types=1);

namespace App\Domain\Dsgvo\Repository;

use App\Domain\Dsgvo\Data\Dsgvo;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Types;

final class DsgvoRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function update(Dsgvo $dsgvo): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('dsgvo')
            ->set('details', ':details')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameter('details', $dsgvo->getDetails())
            ->setParameter('updated_at', $dsgvo->getUpdatedAt(), Types::DATETIME_IMMUTABLE)
            ->setParameter('id', 1)
            ->executeStatement();
    }
}
