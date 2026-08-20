<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Repository;

use App\Domain\Supporter\Data\Supporter;
use Doctrine\DBAL\Connection;

final class SupporterRepository
{
    /**
     * @param Connection $connection Doctrine DBAL connection.
     */
    public function __construct(
        private Connection $connection
    ) {
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

    public function delete(int $id): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('supporters')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery();
    }

    public function existsSupporterId(int $id)
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('id')
            ->from('supporters')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery();

        return (bool) $result;
    }
}
