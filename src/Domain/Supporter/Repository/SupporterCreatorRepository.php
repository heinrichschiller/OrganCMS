<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Repository;

use App\Domain\Supporter\Data\Supporter;
use Doctrine\DBAL\Connection;

final class SupporterCreatorRepository
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
     * Insert new supporter
     *
     * @param Supporter $supporter Supporter
     *
     * @return void
     */
    public function insert(Supporter $supporter): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('supporters')
            ->setValue('name', '?')
            ->setValue('is_published', '?')
            ->setValue('published_at', '?')
            ->setValue('created_at', '?')
            ->setValue('updated_at', '?')
            ->setParameter(0, $supporter->getName())
            ->setParameter(1, $supporter->isPublished())
            ->setParameter(2, $supporter->getPublishedAt())
            ->setParameter(3, $supporter->getCreatedAt())
            ->setParameter(4, $supporter->getUpdatedAt())
            ->executeQuery();
    }
}
