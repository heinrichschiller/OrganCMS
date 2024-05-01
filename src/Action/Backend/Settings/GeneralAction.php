<?php

declare (strict_types=1);

namespace App\Action\Backend\Settings;

use App\Domain\Settings\Service\SettingsReader;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class GeneralAction
{
    /**
     * @Injection
     * @var Settings
     */
    private SettingsReader $reader;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor.
     *
     * @param SettingsReader $reader Settings reader
     * @param TemplateRenderer $renderer Template renderer
     */
    public function __construct(SettingsReader $reader, TemplateRenderer $renderer)
    {
        $this->reader = $reader;
        $this->renderer = $renderer;
    }

    /**
     * The invoker.
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     * @param array<string> $args Get all of the route's parsed arguments.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $data = $this->reader->read();

        $response = $this->renderer->render($response, 'backend/settings/general', $data);

        return $response;
    }
}
