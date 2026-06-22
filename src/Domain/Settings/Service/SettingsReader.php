<?php

declare(strict_types=1);

namespace App\Domain\Settings\Service;

use Selective\Config\Configuration;

final class SettingsReader
{
    public function __construct(
        private Configuration $config
    ) {
        $this->config = $config;
    }

    public function read(): array
    {
        $websiteConfig = $this->config->getArray('html_header');

        $data = [
            'website' => $websiteConfig,
        ];

        return $data;
    }
}
