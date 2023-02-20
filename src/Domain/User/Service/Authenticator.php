<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserAuthRepository;

final class Authenticator
{
    /**
     * @Injection
     * @var UserAuthRepository
     */
    private UserAuthRepository $reader;

    /**
     * The constructor
     *
     * @param UserAuthRepository $reader
     */
    public function __construct(UserAuthRepository $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Authenticates user
     *
     * @param string $identity User identifier (username, usermail, etc.)
     * @param string $credential User password
     */
    public function authenticate(string $identity, string $credential): void
    {
        $this->reader->authenticate($identity, $credential);
    }

    /**
     * Get user name
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->reader->getUsername();
    }
    
    /**
     * Check user authentication
     *
     * @return bool
     */
    public function isAuth(): bool
    {
        return $this->reader->isAuth();
    }
}
