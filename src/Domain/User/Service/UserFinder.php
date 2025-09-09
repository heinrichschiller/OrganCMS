<?php

declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserReaderRepository;
use App\Domain\User\Data\User;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class UserFinder
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var UserReaderRepository
     */
    private UserReaderRepository $repository;

    /**
     * The constructor
     *
     * @param UserReaderRepository $repository - User repository
     */
    public function __construct(LoggerFactory $loggerFactory, UserReaderRepository $repository)
    {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
    }

    /**
     * Get user by username
     *
     * @param string $username - Name of an user
     *
     * @return User|null
     */
    public function findByUsername(string $username): User|null
    {
        try {
            $userItem = (array) $this->repository->findByUsername($username);

            if (!empty($userItem)) {
                $user = new User(
                    $userItem['id'],
                    $userItem['first_name'],
                    $userItem['given_name'],
                    $userItem['username'],
                    $userItem['email'],
                    ''
                );

                return $user;
            }
        
            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("UserReader->getUser(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("UserReader->getUser(): %s", $e->getMessage()));

            return null;
        }
    }
}
