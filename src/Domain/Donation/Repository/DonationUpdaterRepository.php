<?php

declare(strict_types=1);

namespace App\Domain\Donation\Repository;

use App\Domain\Donation\DonationDetails;
use Doctrine\DBAL\Connection;

final class DonationUpdaterRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The constructor
     *
     * @param Connection $connection Doctrine DBAL connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Update donation details
     *
     * @param DonationDetails $donationDetails
     */
    public function update(DonationDetails $donationDetails): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('donation')
            ->set('total', ':total')
            ->set('date', ':date')
            ->set('user', ':user')
            ->where('id = 1')
            ->setParameter('total', $donationDetails->getTotal())
            ->setParameter('date', $donationDetails->getDate())
            ->setParameter('user', $donationDetails->getUser())
            ->executeQuery();
    }
}
