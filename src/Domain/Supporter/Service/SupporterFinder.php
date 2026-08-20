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
    public function __construct(
        private SupporterFinderRepository $repository
    ) {
    }

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

    public function findById(int $id): Supporter
    {
        $data = (array) $this->repository->findById($id);

        if ($data === []) {
            throw new SupporterNotFoundException($id);
        }

        $supporter = $this->transformDataToSupporter($data);

        return $supporter;
    }

    /**
     * @param array<mixed> $supporter
     */
    public function transformDataToSupporter(array $supporter): Supporter
    {
        if (empty($supporter)) {
            return new Supporter;
        }

        return new Supporter(
            id: (int) $supporter['id'],
            name: (string) $supporter['name'],
            isPublished: (bool) $supporter['is_published'],
            publishedAt: $this->parseDate($supporter['published_at']),
            createdAt: $this->parseDate($supporter['created_at']),
            updatedAt: $this->parseDate($supporter['updated_at'])
        );
    }

    private function parseDate(?string $date): ?DateTimeImmutable
    {
        if ($date === null || $date === '') {
            return null;
        }

        return new DateTimeImmutable($date);
    }
}
