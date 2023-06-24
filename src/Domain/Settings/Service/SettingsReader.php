<?php

declare(strict_types=1);

namespace App\Domain\Settings\Service;

use App\Support\Config;

final class SettingsReader
{
    /**
     * @Injection
     * @var Config
     */
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function read(): array
    {
        // $websiteConfig = $this->config->get('html_header');

        // $data = [
        //     'website' => $websiteConfig,
        // ];

        // return $data;
    }
}
