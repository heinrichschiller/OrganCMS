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

$settings['sqlite'] = [
    'driver' => 'pdo_sqlite',
];

$settings['db'] = [
    'driver' => 'pdo_mysql',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_uca1400_ai_ci',

    /**
     * The driverOptions option allows to pass arbitrary options through to the driver.
     * This is equivalent to the fourth argument of the PDO constructor.
     * see: https://www.php.net/manual/en/pdo.construct.php
     */
    'driverOptions' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_uca1400_ai_ci'
    ],
];

$settings['migrations'] = [
	'table_storage' => [
		'table_name' => 'migrations',
		'version_column_length' => 1024,
	],
	'migrations_paths' => [
		'Migrations' => __DIR__ . '/../resources/migrations',
	],
	'all_or_nothing' => true,
	'transactional' => true,
	'check_database_platform' => true,
	'organize_migrations' => 'none',
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
