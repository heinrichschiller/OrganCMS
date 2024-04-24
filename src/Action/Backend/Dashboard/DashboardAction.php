<?php

declare(strict_types=1);

namespace App\Action\Backend\Dashboard;

use App\Domain\Dashboard\Service\DashboardReader;
use App\Renderer\TemplateRenderer;
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
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
    public function __invoke(Response $response): Response
    {
        $data = $this->reader->read();

        $response = $this->renderer->render($response, 'backend/dashboard/dashboard', $data);

        return $response;
    }
}
