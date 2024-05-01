<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\DonationDetails;
use App\Domain\Donation\Repository\DonationDetailsRepository;
use App\Factory\LoggerFactory;
use Exception;
use Psr\Log\LoggerInterface;

final class DonationDetailsReader
{
    /**
     * @Injection
     * @var DonationDetailsRepository
     */
    private DonationDetailsRepository $repository;

    private LoggerInterface $logger;

    /**
     * The constructor
     *
     * @param DonationDetailsRepository $repository Donation details repository
     * @param LoggerFactory $loggerFactory Monolog logger factory.
     */
    public function __construct(
        DonationDetailsRepository $repository,
        LoggerFactory $loggerFactory
    ) {
        $this->repository = $repository;
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
    }

    /**
     * Read donation status
     *
     * @return DonationDetails|null
     */
    public function read(): DonationDetails|null
    {
        try {
            $details =  $this->repository->read();
            
            return new DonationDetails(
                $details['total'],
                $details['date'],
                $details['user']
            );
        } catch (Exception $e) {
            $this->logger->error(sprintf('DonationDetailsReader->read(): %s', $e->getMessage()));

            return null;
            //  throw $e;
        }
    }
}
