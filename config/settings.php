<?php

declare(strict_types=1);

use Monolog\Logger;

return [

    /*
     *----------------------------------------------------------------------------
     * Settings for symfony console commands
     *----------------------------------------------------------------------------
     *
     * For more information, see:
     * https://symfony.com/doc/current/console.html#the-console-app-env-app-debug
     *
     */
    'commands' => [
        // add commands here
    ],

    /*
     *----------------------------------------------------------------------------
     * Settings for ErrorMiddleware
     *----------------------------------------------------------------------------
     *
     * For more information, see:
     * https://www.slimframework.com/docs/v4/middleware/error-handling.html
     *
     */
    'error' => [
        'displayErrorDetails' => $_ENV['DISPLAY_ERROR_DETAILS'],
        'logErrors' => $_ENV['LOG_ERRORS'],
        'logErrorDetails' => $_ENV['LOG_ERROR_DETAILS']
    ],

    /*
     *----------------------------------------------------------------------------
     * Settings for Monolog Logger
     *----------------------------------------------------------------------------
     *
     * For more information, see:
     * https://github.com/Seldaek/monolog
     *
     */
    'logger' => [
        'name' => $_ENV['APP_NAME'],
        'path' => ROOT_DIR . $_ENV['LOGGER_PATH'],
        'filename' => $_ENV['LOGGER_FILENAME'],
        'level' => Logger::DEBUG,
        'filePermission' => $_ENV['LOGGER_FILE_PERMISSIONS']
    ],

    /*
     *----------------------------------------------------------------------------
     * Settings for Mustache template engine
     *----------------------------------------------------------------------------
     *
     * For more information, see:
     * https://github.com/bobthecow/mustache.php
     *
     */
    'mustache' => [
        'cache' => ROOT_DIR . '/var/caches/mustache',
        'charset' => 'UTF-8',
        'escape' => function (string $var) {
            return htmlspecialchars($var, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        },
        'loader' => new Mustache_Loader_FilesystemLoader(
            ROOT_DIR . 'resources/views',
            ['extension' => '.html']
        ),
        'partials_loader' => new Mustache_Loader_FilesystemLoader(
            ROOT_DIR . 'resources/views/partials',
            ['extension' => '.html']
        )
    ],

    /*
     *----------------------------------------------------------------------------
     * Settings for Odan session
     *----------------------------------------------------------------------------
     *
     * For more information, see:
     * https://github.com/odan/session
     *
     */
    'session' => [
        'name' => $_ENV['APP_NAME'],
        'cache_expire' => $_ENV['CACHE_EXPIRE'],
    ],

    /*
     *----------------------------------------------------------------------------
     * Settings for PDO sqlite connection
     *----------------------------------------------------------------------------
     *
     * For more information, see:
     * https://www.php.net/manual/en/book.pdo.php
     * https://www.php.net/manual/en/ref.pdo-sqlite.php
     *
     */
    'database' => [
        'type' => $_ENV['DATABASE_TYPE'],
        'dbname' => ROOT_DIR . $_ENV['DATABASE_NAME']
    ],

    /*
     *----------------------------------------------------------------------------
     * Settings for file upload
     *----------------------------------------------------------------------------
     *
     * See, app/containers.php, FileUploader-Container
     * and app/Domain/Donation/Service/FileUploader.php
     *
     */
    'file_upload' => [
        'upload_directory' => ROOT_DIR . $_ENV['UPLOAD_DIRECTORY']
    ],

    /*
     *----------------------------------------------------------------------------
     * Settings for PHPMailer
     *----------------------------------------------------------------------------
     *
     * For more information, see:
     * https://github.com/PHPMailer/PHPMailer
    */
    'mailer' => [
        'host' => $_ENV['PHPMAILER_HOST'],
        'smtpAuth' => $_ENV['PHPMAILER_SMTP_AUTH'],
        'username' => $_ENV['PHPMAILER_USERNAME'],
        'password' => $_ENV['PHPMAILER_PASSWORD'],
        'smtpSecure' => $_ENV['PHPMAILER_SMTP_SECURE'],
        'port'  => $_ENV['PHPMAILER_PORT']
    ],
];
