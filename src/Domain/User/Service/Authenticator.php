<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserAuthRepository;
use App\Domain\User\Data\User;

final class Authenticator
{
    /**
     * @Injection
     * @var UserAuthRepository
     */
    private UserAuthRepository $repository;

    /**
     * The constructor
     *
     * @param UserAuthRepository $repository
     */
    public function __construct(UserAuthRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Authenticates user
     *
     * @param string $identity User identifier (username, usermail, etc.)
     * @param string $credential User password
     */
    public function authenticate(string $identity, string $credential): void
    {
        $this->repository->authenticate($identity, $credential);
    }

    /**
     * Get user object
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->repository->getUser();
    }
    
    /**
     * Check user authentication
     *
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->repository->isAuth();
    }
}
