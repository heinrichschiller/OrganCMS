<?php

declare(strict_types=1);

namespace App\Renderer;

use Mustache_Engine;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * TemplateRenderer used the Mustache render enginge for rendering html templates.
 *
 * For more informations, see:
 */
final class TemplateRenderer
{
    /**
     * @Injection
     * @var Mustache_Engine;
     */
    private Mustache_Engine $mustache;

    /**
     * The constructor.
     *
     * @param Mustache_Engine $mustache Mustache Render Engine
     */
    public function __construct(Mustache_Engine $mustache)
    {
        $this->mustache = $mustache;
    }

    /**
     * Render a template.
     *
     * @param Response $response Representation of an outgoing, server-side response.
     * @param string $template Name of the html-template that will be rendered.
     * @param array<mixed> $data Data for the html-template.
     *
     * @return Response
     */
    public function render(Response $response, string $template, array $data = []): Response
    {
        $response->getBody()->write(
            $this->mustache->render($template, $data)
        );

        return $response;
    }
}
