<?php

declare(strict_types=1);

use App\Domain\Donation\DonationBoard;
use App\Domain\Donation\Repository\DonationBoardReaderRepository;
use App\Domain\Donation\Repository\DonationUpdaterRepository;
use App\Domain\Donation\Repository\RegisterFinderRepository;
use App\Domain\Donation\Repository\SoundFinderRepository;
use App\Domain\Donation\Repository\WorkFinderRepository;
use App\Domain\Event\Repository\EventCreatorRepository;
use App\Domain\Event\Repository\EventFinderRepository;
use App\Domain\Event\Repository\EventUpdaterRepository;
use App\Domain\User\Repository\UserAuthRepository;
use App\Domain\User\Repository\UserReaderRepository;
use App\Domain\User\Repository\UserUpdaterRepository;
use App\Domain\User\User;
use App\Factory\PDOFactory;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([

        UserReaderRepository::class => function (ContainerInterface $container): UserReaderRepository {
            return new UserReaderRepository(
                $container->get(PDOFactory::class),
                $container->get(User::class)
            );
        },

        UserAuthRepository::class => function (ContainerInterface $container): UserAuthRepository {
            return new UserAuthRepository(
                $container->get(PDOFactory::class),
                $container->get(User::class)
            );
        },
        
        UserUpdaterRepository::class => function (ContainerInterface $container): UserUpdaterRepository {
            return new UserUpdaterRepository(
                $container->get(LoggerInterface::class),
                $container->get(PDOFactory::class),
                $container->get(User::class)
            );
        },

        DonationBoardReaderRepository::class => function (ContainerInterface $container): DonationBoardReaderRepository {
            return new DonationBoardReaderRepository(
                $container->get(PDOFactory::class),
                $container->get(DonationBoard::class)
            );
        },

        DonationUpdaterRepository::class => function (ContainerInterface $container): DonationUpdaterRepository {
            return new DonationUpdaterRepository(
                $container->get(PDOFactory::class),
                $container->get(DonationBoard::class)
            );
        },

        WorkFinderRepository::class => function (ContainerInterface $container): WorkFinderRepository {
            return new WorkFinderRepository(
                $container->get(PDOFactory::class)
            );
        },

        RegisterFinderRepository::class => function (ContainerInterface $container): RegisterFinderRepository {
            return new RegisterFinderRepository(
                $container->get(PDOFactory::class)
            );
        },

        SoundFinderRepository::class => function (ContainerInterface $container): SoundFinderRepository {
            return new SoundFinderRepository(
                $container->get(PDOFactory::class)
            );
        },

        EventCreatorRepository::class => function (ContainerInterface $container): EventCreatorRepository {
            return new EventCreatorRepository(
                $container->get(PDOFactory::class)
            );
        },

        EventFinderRepository::class => function (ContainerInterface $container): EventFinderRepository {
            return new EventFinderRepository(
                $container->get(PDOFactory::class)
            );
        },

        EventUpdaterRepository::class => function(ContainerInterface $container): EventUpdaterRepository
        {
            return new EventUpdaterRepository(
                $container->get(PDOFactory::class)
            );
        }
    ]);
};
