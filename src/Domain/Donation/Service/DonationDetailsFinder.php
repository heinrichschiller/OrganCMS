<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\Data\DonationDetails;
use App\Domain\Donation\Repository\DonationDetailsRepository;

final class DonationDetailsFinder
{
    /**
     * @Injection
     * @var DonationDetailsRepository
     */
    private DonationDetailsRepository $repository;

    /**
     * The constructor
     *
     * @param DonationDetailsRepository $repository Donation details repository
     */
    public function __construct(
        DonationDetailsRepository $repository,
    ) {
        $this->repository = $repository;
    }

    /**
     * Read donation status
     *
     * @return DonationDetails
     */
    public function findOne(): DonationDetails|null
    {
        $details =  $this->repository->findOne();
        
        return new DonationDetails(
            total: $details['total'],
            date: $details['date'],
            user: $details['user']
        );
    }
}
