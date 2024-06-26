<?php

error_reporting(0);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

// List of Supported Timezones
// see, https://www.php.net/manual/en/timezones.php
date_default_timezone_set('Europe/Berlin');

$settings = [];

$settings['commands'] = [
    \App\Console\ExampleCommand::class,
    // Add more here ...
];

// Error handler
$settings['error'] = [
    // Should be set to false for the production environment
    'display_error_details' => false,

    // Should be set to false for the test environment
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,

    // The error logfile
    'log_file' => 'error.log',
];

$settings['logger'] = [
    'name' => 'app',
    'path' => __DIR__ . '/../var/logs/',
    'filename' => 'app.log',
    'level' => \Monolog\Level::Debug,
    'file_permission' => 0775,
];

$settings['db'] = [
    'driver' => 'pdo_sqlite',
];

// url
$url = 'https://www.lutherorgel-plauen.de';

// website
$settings['html_header'] = [
    'frontend_css' => $url . '/assets/css/main.css',
    'backend_css' => $url. '/assets/css/backend.css',
    'userjs' => $url . '/assets/js/main.bundle.js',
    'url' => $url,
];

$settings['html_footer'] = [
    'tinymcejs' => $url . '/assets/js/tinymce.bundle.js',
];

$settings['mustache'] = [
    'cache' => __DIR__ . '/../var/caches/mustache',
    'charset' => 'UTF-8',
    'escape' => function (string $var) {
        return htmlspecialchars($var, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    },
    'loader' => new Mustache_Loader_FilesystemLoader(
        __DIR__ . '/../templates/',
        ['extension' => '.html']
    ),
    'partials_loader' => new Mustache_Loader_FilesystemLoader(
        __DIR__ . '/../templates/partials',
        ['extension' => '.html']
    )
];

$settings['session'] = [
    'name' => 'organcms',
    'lifetime' => 7200,
    'path' => null,
    'domain' => null,
    'secure' => false,
    'httponly' => true,
    'cache_limiter' => 'nocache',
];

$settings['file_upload'] = [
    'dirs' => [
        'files_directory' => __DIR__ . '/../public/assets/files',
    ]
];

return $settings;
