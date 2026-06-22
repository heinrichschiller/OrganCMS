<?php

declare(strict_types=1);

namespace App\Renderer;

use Mustache\Engine;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * TemplateRenderer used the Mustache render enginge for rendering html templates.
 *
 * For more informations, see: https://github.com/bobthecow/mustache.php
 */
final class TemplateRenderer
{
    public function __construct(
        private Engine $mustache,
        private ViewContextFactory $contextFactory
    ) {
    }

    /**
     * @param array<mixed> $data Data for the html-template.
     */
    public function render(
        Response $response,
        string $template,
        array $data = [],
        string $area = 'frontend'
    ): Response {
        $context = $this->contextFactory->create($area, $data);

        $content = $this->mustache->render($template, $context);

        $html = $this->mustache->render($context['layout'], array_replace(
            $context,
            ['content' => $content]
        ));

        $response->getBody()->write($html);

        return $response;
    }

    /**
     * @param array<mixed> $data The data.
     */
    public function renderFrontend(
        Response $response,
        string $template,
        array $data = []
    ): Response {
        return $this->render($response, $template, $data, 'frontend');
    }

    /**
     * @param array<mixed> $data The data.
     */
    public function renderBackend(
        Response $response,
        string $template,
        array $data = []
    ): Response {
        return $this->render($response, $template, $data, 'backend');
    }

    /**
     * @param array<mixed> $data The data.
     */
    public function renderError(
        Response $response,
        string $template,
        array $data = []
    ): Response {
        return $this->render($response, $template, $data, 'error');
    }
}
