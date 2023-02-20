<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\DonationDetails;
use App\Domain\Donation\Repository\DonationUpdaterRepository;
use App\Factory\LoggerFactory;
use App\Support\Config;
use App\Support\FileUploader;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class DonationUpdater
{
    /**
     * @Injection
     * @var Config
     */
    private Config $config;

    /**
     * @Injection
     * @var DonationUpdaterRepository
     */
    private DonationUpdaterRepository $repository;

    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * The constructor
     *
     * @param Config $config Configuration support.
     * @param DonationUpdaterRepository $repository
     * @param LoggerFactory $loggerFactory
     */
    public function __construct(
        Config $config,
        DonationUpdaterRepository $repository,
        LoggerFactory $loggerFactory
    ) {
        $this->config = $config;
        $this->repository = $repository;
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
    }

    /**
     * Update donation status
     *
     * @param array $formData The form data.
     * @param string $username Username.
     *
     * @return bool
     */
    public function update(array $formData, string $username): bool
    {
        $total = (string) ($formData['total'] ?? '');
        $date = (string) ($formData['date'] ?? '');

        $donationDetails = new DonationDetails(
            $total,
            $date,
            $username
        );

        try {
            $this->repository->update($donationDetails);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("DonationUpdater->update: %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("DonationUpdater->update: %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * Upload files.
     *
     * @param array $uploadedFiles Uploaded files
     *
     * @return bool
     */
    public function uploadFiles(array $uploadedFiles): bool
    {
        try {
            $filesDirectory = $this->config->get('file_upload')['dirs']['files_directory'];

            $fileUploader = new FileUploader($filesDirectory);
            $fileUploader->upload($uploadedFiles);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("DonationUpdater->update: %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("DonationUpdater->update: %s", $e->getMessage()));

            return false;
        }
    }
}
