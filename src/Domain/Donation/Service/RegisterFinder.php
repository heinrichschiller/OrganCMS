<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\Repository\RegisterFinderRepository;

final class RegisterFinder
{
    /**
     * @Injection
     * @var RegisterFinderRepository
     */
    private RegisterFinderRepository $repository;

    /**
     * The constructor.
     * 
     * @param RegisterFinderRepository $repository
     */
    public function __construct(RegisterFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find all organ register.
     * 
     * @return array<Register>
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}