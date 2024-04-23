<?php

declare(strict_types=1);

namespace App\Domain\Author\Service;

use App\Domain\Author\Repository\AuthorFinderRepository;

final class AuthorFinder
{
    /**
     * @Injection
     * @var AuthorFinderRepository
     */
    private AuthorFinderRepository $repository;

    /**
     * @param AuthorFinderRepository $repository
     */
    public function __construct(AuthorFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find an author by id.
     *
     * @param int $id Author id.
     *
     * @return array<mixed>
     */
    public function findByIdOrFail(int $id): array
    {
        return $this->repository->findByIdOrFail($id);
    }
}
