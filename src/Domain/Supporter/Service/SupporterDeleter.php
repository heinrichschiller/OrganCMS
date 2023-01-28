<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterDeleterRepository;

final class SupporterDeleter
{
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
    public function __construct(SupporterDeleterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete supporter by id.
     *
     * @param int $id Supporter id.
     */
    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
