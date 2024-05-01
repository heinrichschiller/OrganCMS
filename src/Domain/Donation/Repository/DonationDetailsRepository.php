<?php

declare (strict_types=1);

namespace App\Domain\Donation\Repository;

use Doctrine\DBAL\Connection;

final class DonationDetailsRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Read donation details
     *
     * @return array
     */
    public function read(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('total', 'date', 'user')
            ->from('donation')
            ->executeQuery()
            ->fetchAssociative() ?: [];

        return $result;
    }
}
