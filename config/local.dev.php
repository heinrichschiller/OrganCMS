<?php

return function (array $settings): array {
    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    $settings['error']['display_error_details'] = true;
    $settings['logger']['level'] = \Monolog\Level::Debug;

    // Database
    $settings['db']['path'] = __DIR__ . '/../data/donations-test.db';

    // url
    $url = 'http://127.0.0.1:8000';

    // website
    $settings['html_header'] = [
        'frontend_css' => $url . '/assets/css/main.css',
        'backend_css' => $url . '/assets/css/backend.css',
        'userjs' => $url . '/assets/js/main.bundle.js',
        'url' => $url,
    ];

    $settings['html_footer'] = [
        'tinymcejs' => $url . '/assets/js/tinymce.bundle.js',
    ];
    
    return $settings;
};
