<?php

declare (strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterFinderRepository;
use App\Domain\Supporter\Data\Supporter;
use App\Domain\Supporter\Data\SupporterCollection;
use App\Factory\LoggerFactory;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Throwable;

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
    public function __construct(
        LoggerFactory $loggerFactory,
        SupporterFinderRepository $repository
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('supporter-finder-error.log')
            ->createLogger();

        $this->repository = $repository;
    }

    /**
     * Find all supporter.
     *
     * @return SupporterCollection
     */
    public function findAll(): SupporterCollection
    {
        $supporterItems = (array) $this->repository->findAll();

        $collection = new SupporterCollection;
        foreach ($supporterItems as $supporterItem) {
            $supporter = $this->transformDataToSupporter($supporterItem);

            $collection->add($supporter);
        }

        return $collection;
    }

    /**
     * Find all published supporter.
     *
     * @return SupporterCollection|null
     */
    public function findAllPublicSupporter(): SupporterCollection
    {
        $supporterItems = (array) $this->repository->findAllPublicSupporter();

        $collection = new SupporterCollection;
        foreach ($supporterItems as $supporterItem) {
            $supporter = $this->transformDataToSupporter($supporterItem);

            $collection->add($supporter);
        }

        return $collection;
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
        $supporterItem = (array) $this->repository->findById($id);

        $supporter = $this->transformDataToSupporter($supporterItem);

        return $supporter;
    }

    /**
     * Transform array with supporter-data to Supporter object.
     *
     * @param array<mixed> $supporter Array that contains supporter data.
     *
     * @return Supporter
     */
    public function transformDataToSupporter(array $supporter): Supporter
    {
        if (empty($supporter)) {
            return new Supporter;
        }

        $supporter = new Supporter(
            id: $supporter['id'],
            name: $supporter['name'],
            isPublished: (bool) $supporter['is_published'],
            publishedAt: $this->parseDate($supporter['published_at']),
            createdAt: $this->parseDate($supporter['created_at']),
            updatedAt: $this->parseDate($supporter['updated_at'])
        );

        return $supporter;
    }

    /**
     * Parse date.
     *
     * @param null|string $date Date
     *
     * @throw
     *
     * @return null|DateTimeImmutable
     */
    private function parseDate(?string $date): ?DateTimeImmutable
    {
        if ($date === null || $date === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($date);
        } catch (Throwable $t) {
            $this->logger->warning(
                'Invalid date in SupporterFinder',
                ['value' => $date, 'exception' => $t]
            );

            return null;
        }
    }
}
