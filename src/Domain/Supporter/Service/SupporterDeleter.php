<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterDeleterRepository;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class SupporterDeleter
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Incjection
     * @var SupporterDeleterRepository
     */
    private SupporterDeleterRepository $repository;

    /**
     * The constructor.
     *
     * @param SupporterDeleterRepository $repository Supporter deleter repository
     */
    public function __construct(LoggerFactory $loggerFactory, SupporterDeleterRepository $repository)
    {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
    }

    /**
     * Delete supporter by id.
     *
     * @param int $id Supporter id.
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            $this->repository->delete($id);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));

            return false;
        }
    }
}
