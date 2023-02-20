<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use Doctrine\DBAL\Connection;

final class PostDeleterRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection Doctrine DBAL connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Delete supporter by id.
     *
     * @param int $id Post id.
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('posts')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery();
    }
}
