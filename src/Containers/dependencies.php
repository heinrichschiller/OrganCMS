<?php

/**
 * MIT License
 *
 * Copyright (c) 2020 - 2021 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

declare(strict_types=1);

use App\Domain\Donation\DonationBoard;
use App\Domain\Donation\Repository\DonationBoardReaderRepository;
use App\Domain\Donation\Repository\DonationUpdaterRepository;
use App\Domain\Donation\Repository\RegisterFinderRepository;
use App\Domain\Donation\Repository\SoundFinderRepository;
use App\Domain\Donation\Repository\WorkFinderRepository;
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
        }
    ]);
};
