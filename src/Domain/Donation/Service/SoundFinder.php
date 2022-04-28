<?php

declare(strict_types=1);

namespace App\Domain\Donation\Service;

use App\Domain\Donation\Repository\SoundFinderRepository;

final class SoundFinder
{
    /**
     * @Injection
     * @var SoundFinderRepository
     */
    private SoundFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param SoundFinderRepository $repository
     */
    public function __construct(SoundFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find all sounds by work and register name
     *
     * @param string $work      Organ work
     * @param string $register  Organ register
     *
     * @return array<Sound>     List of organ sounds
     */
    public function findAllBy(string $work, string $register): array
    {
        // workaround:
        $register = str_replace('-', '/', $register);

        return $this->repository->findAllBy($work, $register);
    }
}
