<?php

declare (strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterFinderRepository;
use App\Domain\Supporter\Supporter;
use App\Domain\Supporter\SupporterCollection;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class SupporterFinder
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Injection
     * @var SupporterFinderRepository
     */
    private SupporterFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory
     * @param SupporterFinderRepository $repository Supporter finder repository
     */
    public function __construct(LoggerFactory $loggerFactory, SupporterFinderRepository $repository)
    {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
    }

    /**
     * Find all supporter.
     *
     * @return SupporterCollection|null
     */
    public function findAll(): SupporterCollection|null
    {
        try {
            $supporterList = $this->repository->findAll();

            if (!empty($supporterList)) {
                $collection = new SupporterCollection;
                foreach ($supporterList as $supporterItem) {
                    $supporter = new Supporter(
                        (int) $supporterItem['id'],
                        $supporterItem['name'],
                        (bool) $supporterItem['is_published'],
                        $supporterItem['published_at'],
                        $supporterItem['created_at'],
                        $supporterItem['updated_at']
                    );

                    $collection->add($supporter);
                }

                return $collection;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->findAll(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * Find all published supporter.
     *
     * @return SupporterCollection|null
     */
    public function findAllPublicSupporter(): SupporterCollection|null
    {
        try {
            $supporterList = $this->repository->findAllPublicSupporter();

            if (!empty($supporterList)) {
                $collection = new SupporterCollection;
                foreach ($supporterList as $supporterItem) {
                    $supporter = new Supporter(
                        (int) $supporterItem['id'],
                        $supporterItem['name'],
                        (bool) $supporterItem['is_published'],
                        $supporterItem['published_at'],
                        $supporterItem['created_at'],
                        (string) $supporterItem['updated_at']
                    );
        
                    $collection->add($supporter);
                }
        
                return $collection;
            }
    
            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->findAllPublicSupporter(): %s", $e->getMessage()));
            return null;
        }
    }

    /**
     * Find a supporter by id.
     *
     * @param int $id Id of the supporter.
     *
     * @return Supporter|null
     */
    public function findById(int $id): Supporter|null
    {
        try {
            $supporterItem = $this->repository->findById($id);

            if (!empty($supporterItem)) {
                $supporter = new Supporter(
                    (int) $supporterItem['id'],
                    $supporterItem['name'],
                    (bool) $supporterItem['is_published'],
                    $supporterItem['published_at'],
                    $supporterItem['created_at'],
                    $supporterItem['updated_at']
                );
    
                return $supporter;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->findById(): %s", $e->getMessage()));
            return 0;
        }
    }
}
