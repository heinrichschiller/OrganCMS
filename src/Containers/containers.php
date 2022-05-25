<?php

declare(strict_types=1);

use App\Domain\Donation\Service\FileUploader;
use App\Factory\PDOFactory;
use DI\ContainerBuilder;
use Odan\Session\Middleware\SessionMiddleware;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use PHPMailer\PHPMailer\PHPMailer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Views\Mustache;
use Slim\Views\ViewInterface;

return function (ContainerBuilder $builder) {
    $builder->addDefinitions([
        'settings' => function () {
            return require ROOT_DIR . 'config/settings.php';
        },

        ViewInterface::class => function (ContainerInterface $container): ViewInterface {
            $options = $container->get('settings')['mustache'];

            return new Mustache($options);
        },

        SessionInterface::class => function (ContainerInterface $container): SessionInterface {
            $settings = $container->get('settings')['session'];

            $session = new PhpSession();
            $session->setOptions((array) $settings);

            return $session;
        },

        SessionMiddleware::class => function (ContainerInterface $container) {
            return new SessionMiddleware($container->get(SessionInterface::class));
        },

        ResponseFactoryInterface::class => function (ContainerInterface $container) {
            return $container->get(App::class)->getResponseFactory();
        },

        PDOFactory::class => function (ContainerInterface $container): PDO {
            $options = $container->get('settings')['database'];
            $logger = $container->get(LoggerInterface::class);

            $pdo = new PDOFactory($logger, $options);

            return $pdo->create();
        },

        FileUploader::class => function (ContainerInterface $container): FileUploader {
            $uploadDir = $container->get('settings')['file_upload']['upload_directory'];

            return new FileUploader($uploadDir);
        },

        PHPMailer::class => function (ContainerInterface $container): PHPMailer {
            $settings = $container->get('settings')['mailer'];

            $mailer = new PHPMailer(true);

            $mailer->isSMTP();
            $mailer->Host       = $settings['host'];
            $mailer->SMTPAuth   = $settings['smtpAuth'];
            $mailer->Username   = $settings['username'];
            $mailer->Password   = $settings['password'];
            $mailer->SMTPSecure = $settings['smtpSecure'];
            $mailer->Port       = $settings['port'];
            $mailer->CharSet    = "UTF-8";

            return $mailer;
        },
    ]);
};
