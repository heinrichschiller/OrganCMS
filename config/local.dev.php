<?php

return function (array $settings): array {
    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    // url
    $url = 'https://127.0.0.1:8000';

    // website
    $settings['html_header'] = [
        'css' => $url . '/assets/css/main.css',
        'userjs' => $url . '/assets/js/main.bundle.js',
        'url' => $url,
    ];

    $settings['html_footer'] = [
        'tinymcejs' => $url . '/assets/js/tinymce.bundle.js',
    ];

    $settings['error']['display_error_details'] = true;
    $settings['logger']['level'] = \Monolog\Level::Debug;

    // Database
    $settings['db']['path'] = __DIR__ . '/../data/donations.db';

    return $settings;
};
