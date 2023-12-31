<?php

declare(strict_types=1);

use App\Factory\LoggerFactory;
use App\Handler\NotFoundHandler;
use App\Support\Config;
use Doctrine\DBAL\Configuration as DoctrineConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Odan\Session\SessionManagerInterface;
use Psr\Container\ContainerInterface;
use Selective\BasePath\BasePathMiddleware;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputOption;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        $app = AppFactory::createFromContainer($container);

        /*
         *----------------------------------------------------------------------------
         * Register routes
         *----------------------------------------------------------------------------
         *
         * For more informations see:
         * https://www.slimframework.com/docs/v4/objects/routing.html
         *
         */
        (require __DIR__ . '/routes.php')($app);

        /*
         *----------------------------------------------------------------------------
         * Register middleware
         *----------------------------------------------------------------------------
         *
         * For more informations see:
         * https://www.slimframework.com/docs/v4/concepts/middleware.html
         *
         */
        (require __DIR__ . '/middleware.php')($app);

        return $app;
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
    
    Config::class => function (ContainerInterface $container): Config {
        $settings = (array) $container->get('settings');

        return new Config($settings);
    },

    ErrorMiddleware::class => function (ContainerInterface $container): ErrorMiddleware {
        $settings = (array) $container->get('settings')['error'];
        $app = $container->get(App::class);

        $logger = null;
        if (isset($settings['log_file'])) {
            $logger = $container->get(LoggerFactory::class)
                ->addFileHandler($settings['log_file'])
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

        // Set the Not Found Error
        $errorMiddleware->setErrorHandler(HttpNotFoundException::class, NotFoundHandler::class);

        return $errorMiddleware;
    },

    LoggerFactory::class => function (ContainerInterface $container): LoggerFactory {
        return new LoggerFactory($container->get('settings')['logger']);
    },

    Connection::class => function (ContainerInterface $container) {
        $config = new DoctrineConfiguration();
        $connectionParams = $container->get('settings')['db'];

        return DriverManager::getConnection($connectionParams, $config);
    },

    PDO::class => function (ContainerInterface $container) {
        return $container->get(Connection::class)->getNativeConnection();
    },

    Mustache_Engine::class => function (ContainerInterface $container): Mustache_Engine {
        return new Mustache_Engine($container->get('settings')['mustache']);
    },

    SessionManagerInterface::class => function (ContainerInterface $container): SessionInterface {
        return $container->get(SessionInterface::class);
    },

    SessionInterface::class => function (ContainerInterface $container): SessionInterface {
        $options = $container->get('settings')['session'];

        return new PhpSession($options);
    },

    // ResponseFactoryInterface::class => function (ContainerInterface $container) {
    //     return $container->get(App::class)->getResponseFactory();
    // },
];
