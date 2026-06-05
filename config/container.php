<?php

declare(strict_types=1);

use App\Factory\LoggerFactory;
use App\Handler\NotFoundHandler;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use FastRoute\Route;
use Mustache\Engine;
use Nyholm\Psr7\Factory\Psr17Factory;
use Odan\Session\FlashInterface;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Odan\Session\SessionManagerInterface;
use Psr\Container\ContainerInterface as Container;
use Selective\BasePath\BasePathMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Selective\Config\Configuration;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Interfaces\RouteParserInterface;
use Slim\Middleware\ErrorMiddleware;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

return [
    Configuration::class => function () {
        return new Configuration(require __DIR__ . '/settings.php');
    },

    Application::class => function (Container $container) {
        $application = new Application();
        $config = $container->get(Configuration::class);

        $application->getDefinition()->addOption(
            new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev')
        );

        foreach ($config->getArray('commands') as $class) {
            $application->addCommand($container->get($class));
        }

        return $application;
    },

    BasePathMiddleware::class => function (Container $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    ErrorMiddleware::class => function (Container $container): ErrorMiddleware {
        $config = $container->get(Configuration::class);
        $app = $container->get(App::class);

        $logger = null;
        if ($config->getString('error.log_file')) {
            $logger = $container->get(LoggerFactory::class)
                ->addFileHandler($config->getString('error.log_file'))
                ->createLogger();
        }

        $errorMiddleware = new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $config->getString('error.display_error_details'),
            (bool) $config->getString('error.log_errors'),
            (bool) $config->getString('error.log_error_details'),
            $logger
        );

        $errorMiddleware->setErrorHandler(
            HttpNotFoundException::class,
            NotFoundHandler::class
        );

        return $errorMiddleware;
    },

    LoggerFactory::class => function (Container $container): LoggerFactory {
        $config = $container->get(Configuration::class);

        return new LoggerFactory(
            $config->getArray('logger')
        );
    },

    Connection::class => function (Container $container) {
        $doctrineConfig = new DoctrineConfiguration();
        $config = $container->get(Configuration::class);

        return DriverManager::getConnection(
            $config->getArray('db'),
            $doctrineConfig
        );
    },

    PDO::class => function (Container $container) {
        return $container
            ->get(Connection::class)
            ->getNativeConnection();
    },

    Engine::class => function (Container $container): Engine {
        $config = $container->get(Configuration::class);

        return new Engine($config->getArray('mustache'));
    },

    SessionManagerInterface::class => function (Container $container): SessionInterface {
        return $container->get(SessionInterface::class);
    },

    SessionInterface::class => function (Container $container): SessionInterface {
        $config = $container->get(Configuration::class);

        return new PhpSession($config->getArray('session'));
    },

    ResponseFactoryInterface::class => function (Container $container) {
        return $container->get(Psr17Factory::class);
    },

    ServerRequestFactoryInterface::class => function (Container $container) {
        return $container->get(Psr17Factory::class);
    },

    FlashInterface::class => function (Container $container): FlashInterface {
        return $container->get(SessionInterface::class)->getFlash();
    },

    CustomFlash::class => function (Container $container): CustomFlash {
        return new CustomFlash($container->get(FlashInterface::class));
    },

    RouteParserInterface::class => function (Container $container): RouteParserInterface {
        $app = $container->get(App::class);

        return $app->getRouteCollector()->getRouteParser();
    },

    RedirectResponder::class => function (Container $container): RedirectResponder {
        return new RedirectResponder(
            $container->get(RouteParserInterface::class)
        );
    },
];
