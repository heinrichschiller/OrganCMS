<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\Repository\DonationUpdaterRepository;

final class DonationUpdater
{
    /**
     * @Injection
     * @var DonationUpdaterRepository
     */
    private DonationUpdaterRepository $repository;

    /**
     * The constructor
     *
     * @param DonationUpdaterRepository $repository
     */
    public function __construct(DonationUpdaterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Update donation status
     *
     * @param string $total The total amount of donations
     * @param string $date  Month date
     * @param string $user  User who last update
     */
    public function update(string $total, string $date, string $user): void
    {
        $date = $this->formateDate($date);

        $this->repository->update($total, $date, $user);
    }

    private function formateDate(string $date): string
    {
        $datePieces = explode('-', $date);

        return sprintf('%s.%s.%s', $datePieces[2], $datePieces[1], $datePieces[0]);
    }
}
