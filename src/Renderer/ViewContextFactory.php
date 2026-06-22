<?php

declare(strict_types=1);

namespace App\Renderer;

use Selective\Config\Configuration;

final class ViewContextFactory
{
    public function __construct(
        private Configuration $config
    ) {
    }

    public function create(string $area, array $data = []): array
    {
        $viewConfig = $this->config->getArray('view');

        $globals = $viewConfig['globals'] ?? [];
        $areas = $viewConfig['areas'] ?? [];

        if (!isset($areas[$area])) {
            throw new \InvalidArgumentException(sprintf('Unknown view area: %s', $area));
        }

        $areaConfig = $areas[$area];

        $baseContext = [
            'app' => $globals,
            'layout' => $areaConfig['layout'] ?? 'layout/frontend',
            'body_class' => $areaConfig['body_class'] ?? $area,
            'assets' => $areaConfig['assets'] ?? [
                'css' => [],
                'js' => [],
            ],
            'features' => $viewConfig['features'] ?? [],
            'area' => $area,
        ];

        return array_replace_recursive($baseContext, $data);
    }
}
