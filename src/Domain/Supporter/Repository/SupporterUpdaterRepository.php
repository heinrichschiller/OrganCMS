<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Repository;

use App\Domain\Supporter\Data\Supporter;
use Doctrine\DBAL\Connection;

final class SupporterUpdaterRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection Doctrine DBAL connection.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Update supporter entry.
     *
     * @param Supporter $supporter
     *
     * @return void
     */
    public function update(Supporter $supporter): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('supporters')
            ->set('name', ':name')
            ->set('is_published', ':is_published')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameter('name', $supporter->getName())
            ->setParameter('is_published', (bool) $supporter->isPublished())
            ->setParameter('updated_at', $supporter->getUpdatedAt())
            ->setParameter('id', $supporter->getId())
            ->executeQuery();
    }
}
