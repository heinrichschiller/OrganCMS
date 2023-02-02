<?php

declare(strict_types=1);

namespace App\Action\Home;

use App\Domain\Home\Service\HomeReader;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class HomeAction
{
    /**
     * @Injection
     * @var HomeReader
     */
    private HomeReader $reader;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor.
     *
     * @param HomeReader $reader Home reader service
     * @param TemplateRenderer $renderer Template renderer
     */
    public function __construct(HomeReader $reader, TemplateRenderer $renderer)
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

        $response = $this->renderer->render($response, 'home/index', $data);

        return $response;
    }
}
