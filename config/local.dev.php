<?php

return function (array $settings): array {
    // Error reporting
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');

    // url
    $url = 'https://localhost:8000';

    // website
    $settings['html_header'] = [
        'css' => $url . '/assets/css/custom.css',
        'js' => $url . '/assets/js/bundle.js',
        'url' => $url,
    ];

    $settings['html_footer'] = [];

    $settings['error']['display_error_details'] = true;
    $settings['logger']['level'] = \Monolog\Level::Debug;

    // Database
    $settings['db']['path'] = __DIR__ . '/../data/donations-test.db';

    return $settings;
};
