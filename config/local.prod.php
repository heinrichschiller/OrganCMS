<?php

return function (array $settings): array {
    $settings['db']['path'] = __DIR__ . '/../data/donations.db';

    return $settings;
};
