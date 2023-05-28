<?php

error_reporting(0);
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');

date_default_timezone_set('Europe/Berlin');

$settings = [];

// url
$url = 'https://www.lutherorgel-plauen.de';

// website
$settings['html_header'] = [
    'css' => $url . '/assets/css/custom.css',
    'js' => $url . '/assets/js/bundle.js',
    'url' => $url,
];

$settings['html_footer'] = [];

// Error handler
$settings['error'] = [
    // Should be set to false for the production environment
    'display_error_details' => false,
    // Should be set to false for the test environment
    'log_errors' => true,
    // Display error details in error log
    'log_error_details' => true,
];

$settings['logger'] = [
    // 'name' => 'OrganCMS',
    'path' => __DIR__ . '/../var/logs/',
    // 'filename' => 'OrganCMS.log',
    'level' => \Monolog\Level::Debug,
    'file_permission' => 0775,
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

$settings['db'] = [
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../data/donations.db',
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
