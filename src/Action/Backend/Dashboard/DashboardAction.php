<?php

declare(strict_types=1);

namespace App\Action\Backend\Dashboard;

use App\Domain\Dashboard\Service\DashboardReader;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class DashboardAction
{
    /**
     * @Injection
     * @var DashboardReader
     */
    private DashboardReader $reader;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor
     *
     * @param DashboardReader $reader
     * @param TemplateRenderer $renderer
     */
    public function __construct(DashboardReader $reader, TemplateRenderer $renderer)
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

        $response = $this->renderer->render($response, 'backend/dashboard/dashboard', $data);

        return $response;
    }
}
