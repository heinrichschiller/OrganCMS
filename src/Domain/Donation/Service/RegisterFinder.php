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
     * @param string $register
     * @return array<Register>
     */
    public function findAll(string $register): array
    {
        return $this->repository->findAll($register);
    }
}