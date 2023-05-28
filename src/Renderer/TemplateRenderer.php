<?php

declare(strict_types=1);

namespace App\Renderer;

use Mustache_Engine;
use App\Support\Config;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * TemplateRenderer used the Mustache render enginge for rendering html templates.
 *
 * For more informations, see:
 */
final class TemplateRenderer
{
    private Config $config;

    /**
     * @Injection
     * @var Mustache_Engine;
     */
    private Mustache_Engine $mustache;

    /**
     * The constructor.
     *
     * @param Config $config 
     * @param Mustache_Engine $mustache Mustache Render Engine
     */
    public function __construct(Config $config, Mustache_Engine $mustache)
    {
        $this->config = $config;
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
        $configHeader = $this->config->get('html_header');
        $configFooter = $this->config->get('html_footer');

        $renderData = [
            'header' => $configHeader,
            'footer' => $configFooter
        ];

        if(!empty($data)) {
            foreach($data as $key => $value) {
                $renderData[$key] = $data[$key];
            } 
        }

        $response->getBody()->write(
            $this->mustache->render($template, $renderData)
        );

        return $response;
    }
}
