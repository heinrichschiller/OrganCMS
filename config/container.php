<?php

declare(strict_types=1);

use App\Factory\LoggerFactory;
use App\Support\Config;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Odan\Session\SessionManagerInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    Config::class => function (ContainerInterface $container): Config {
        $settings = (array) $container->get('settings');

        return new Config($settings);
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container): ErrorMiddleware {
        $settings = $container->get('settings')['error'];

        $app = $container->get(App::class);

        $logger = null;
        if (isset($settings['log_file'])) {
            $logger = $container->get(LoggerFactory::class)
                ->addFileHandler('error.log')
                ->createLogger();
        }

        $errorMiddleware = new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $settings['display_error_details'],
            (bool) $settings['log_errors'],
            (bool) $settings['log_error_details'],
            $logger
        );
        
        return $errorMiddleware;
    },

    LoggerFactory::class => function (ContainerInterface $container): LoggerFactory {
        return new LoggerFactory($container->get('settings')['logger']);
    },

    Mustache_Engine::class => function (ContainerInterface $container): Mustache_Engine {
        return new Mustache_Engine($container->get('settings')['mustache']);
    },

    Connection::class => function (ContainerInterface $container) {
        $config = new DoctrineConfiguration();
        $connectionParams = $container->get('settings')['db'];

        return DriverManager::getConnection($connectionParams, $config);
    },

    PDO::class => function (ContainerInterface $container) {
        return $container->get(Connection::class)->getNativeConnection();
    },

    SessionManagerInterface::class => function (ContainerInterface $container): SessionInterface {
        return $container->get(SessionInterface::class);
    },

    SessionInterface::class => function (ContainerInterface $container): SessionInterface {
        $options = $container->get('settings')['session'];

        return new PhpSession($options);
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },
];
