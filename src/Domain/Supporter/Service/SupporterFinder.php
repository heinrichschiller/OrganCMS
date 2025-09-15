<?php

declare (strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterFinderRepository;
use App\Domain\Supporter\Data\Supporter;
use App\Domain\Supporter\Data\SupporterCollection;
use App\Factory\LoggerFactory;
use DateTimeImmutable;
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
        $this->logger = $loggerFactory->addFileHandler('supporter-finder-error.log')->createLogger();
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
            $supporterList = (array) $this->repository->findAll();

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

            return null;
        }
    }

    /**
     * Find all published supporter.
     *
     * @return SupporterCollection|null
     */
    public function findAllPublicSupporter(): SupporterCollection
    {
        $collection = new SupporterCollection;

        try {
            $supporterList = (array) $this->repository->findAllPublicSupporter();

        if (!empty($supporterList)) {
            foreach ($supporterList as $supporterItem) {
                $supporter = $this->transformSupporter($supporterItem);

                $collection->add($supporter);
            }
        
            return $collection;
        }

            return $collection;
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->findAllPublicSupporter(): %s", $e->getMessage()));
            
            return $collection;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->findAllPublicSupporter(): %s", $e->getMessage()));
            
            return $collection;
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
            $supporterItem = (array) $this->repository->findById($id);

            if (!empty($supporterItem)) {
                $supporter = $this->transformSupporter($supporterItem);
    
                return $supporter;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->findById(): %s", $e->getMessage()));
            
            return null;
        }
    }

    /**
     * Transform supporter array to supporter object.
     *
     * @param array<mixed> $supporter Array that contains supporter data.
     *
     * @return Supporter
     */
    public function transformSupporter(array $supporter): Supporter
    {
        $publishedAt = null;
        if ($supporter['published_at'] !== null && $supporter['published_at'] !== '') {
            $publishedAt = new DateTimeImmutable($supporter['published_at']);
        }

        $createdAt = null;
        if ($supporter['created_at'] !== null && $supporter['created_at'] !== '') {
            $createdAt = new DateTimeImmutable($supporter['created_at']);
        }

        $updatedAt = null;
        if ($supporter['updated_at'] !== null && $supporter['updated_at'] !== '') {
            $updatedAt = new DateTimeImmutable($supporter['updated_at']);
        }

        $isPublished = false;
        if ($supporter['is_published'] !== null && $supporter['is_published'] !== '') {
            $isPublished = true;
        }

        $supporter = new Supporter(
            id: $supporter['id'],
            name: $supporter['name'],
            isPublished: $isPublished,
            publishedAt: $publishedAt,
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        return $supporter;
    }
}
