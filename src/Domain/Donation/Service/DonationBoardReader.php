<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\DonationBoard;
use App\Domain\Donation\Repository\DonationBoardReaderRepository;

final class DonationBoardReader
{
    /**
     * @Injection
     * @var DonationBoardReaderRepository
     */
    private DonationBoardReaderRepository $repository;

    /**
     * The constructor
     *
     * @param DonationBoardReaderRepository
     */
    public function __construct(DonationBoardReaderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read donation status
     *
     * @return DonationBoard
     */
    public function read(): DonationBoard
    {
        return $this->repository->read();
    }
}
