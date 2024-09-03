<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Repository\EventRepository;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class EventDeleter
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Incjection
     * @var EventRepository
     */
    private EventRepository $repository;

    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory Logger factory
     * @param EventRepository $repository Supporter deleter repository
     */
    public function __construct(LoggerFactory $loggerFactory, EventRepository $repository)
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
            $this->logger->error(sprintf("EventFinder->delete(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->delete(): %s", $e->getMessage()));

            return false;
        }
    }
}
