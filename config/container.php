<?php

declare(strict_types=1);

use App\Factory\LoggerFactory;
use App\Handler\NotFoundHandler;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Nyholm\Psr7\Factory\Psr17Factory;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Odan\Session\SessionManagerInterface;
use Psr\Container\ContainerInterface;
use Selective\BasePath\BasePathMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\Config\Configuration;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

return [
    Configuration::class => function () {
        return new Configuration(require __DIR__ . '/settings.php');
    },

    Application::class => function (ContainerInterface $container) {
        $application = new Application();

        $application->getDefinition()->addOption(
            new InputOption('--env', '-e', InputOption::VALUE_REQUIRED, 'The Environment name.', 'dev')
        );

        foreach ($container->get('settings')['commands'] as $class) {
            $application->add($container->get($class));
        }

        return $application;
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    ErrorMiddleware::class => function (ContainerInterface $container): ErrorMiddleware {
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

        // Set the Not Found Error
        $errorMiddleware->setErrorHandler(HttpNotFoundException::class, NotFoundHandler::class);

        return $errorMiddleware;
    },

    LoggerFactory::class => function (ContainerInterface $container): LoggerFactory {
        $config = $container->get(Configuration::class);

        return new LoggerFactory($config->getArray('logger'));
    },

    Connection::class => function (ContainerInterface $container) {
        $doctrineConfig = new DoctrineConfiguration();
        $config = $container->get(Configuration::class);

        return DriverManager::getConnection(
            $config->getArray('db'),
            $doctrineConfig
        );
    },

    PDO::class => function (ContainerInterface $container) {
        return $container->get(Connection::class)->getNativeConnection();
    },

    Mustache_Engine::class => function (ContainerInterface $container): Mustache_Engine {
        $config = $container->get(Configuration::class);

        return new Mustache_Engine($config->getArray('mustache'));
    },

    SessionManagerInterface::class => function (ContainerInterface $container): SessionInterface {
        return $container->get(SessionInterface::class);
    },

    SessionInterface::class => function (ContainerInterface $container): SessionInterface {
        $config = $container->get(Configuration::class);

        return new PhpSession($config->getArray('session'));
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },
];
