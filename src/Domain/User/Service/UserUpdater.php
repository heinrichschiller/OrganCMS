<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\User;
use App\Domain\User\Repository\UserUpdaterRepository;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class UserUpdater
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Injection
     * @var UserUpdaterRepository
     */
    private UserUpdaterRepository $repository;

    /**
     * The constructor
     *
     * @param UserUpdaterRepository $repository
     */
    public function __construct(LoggerFactory $loggerFactory, UserUpdaterRepository $repository)
    {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
    }

    /**
     * Update user
     *
     * @param string $identity      User identifier (username, email, etc)
     * @param string $credentials   User password
     *
     * @return bool
     */
    public function update(string $identity, string $credentials): bool
    {
        $user = new User(
            null,
            '',
            '',
            $identity,
            '',
            $credentials
        );

        try {
            $this->repository->update($user);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf('UserUpdater->update(): %s', $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf('UserUpdater->update(): %s', $e->getMessage()));
            
            return false;
        }
    }
}
