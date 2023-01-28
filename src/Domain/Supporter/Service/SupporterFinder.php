<?php

declare (strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterFinderRepository;
use App\Domain\Supporter\Supporter;
use App\Domain\Supporter\SupporterCollection;

final class SupporterFinder
{
    /**
     * @Injection
     * @var SupporterFinderRepository
     */
    private SupporterFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param SupporterFinderRepository $repository Supporter finder repository
     */
    public function __construct(SupporterFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find all supporter.
     *
     * @return SupporterCollection
     */
    public function findAll(): SupporterCollection
    {
        return $this->repository->findAll();
    }

    /**
     * Find a supporter by id.
     *
     * @param int $id Id of the supporter.
     *
     * @return Supporter
     */
    public function findById(int $id): Supporter
    {
        return $this->repository->findById($id);
    }
}
