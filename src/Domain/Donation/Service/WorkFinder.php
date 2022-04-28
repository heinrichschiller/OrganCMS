<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\Repository\WorkFinderRepository;

final class WorkFinder
{
    /**
     * @Injection
     * @var WorkFinderRepository
     */
    private WorkFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param WorkFinderRepository $repository
     */
    public function __construct(WorkFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find all organ works.
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}
