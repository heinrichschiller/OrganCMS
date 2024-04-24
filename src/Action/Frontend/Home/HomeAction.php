<?php

declare(strict_types=1);

namespace App\Action\Frontend\Home;

use App\Domain\Home\Service\HomeReader;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ResponseInterface as Response;

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
     * @param Response $response Representation of an outgoing, server-side response.
     *
     * @return Response
     */
    public function __invoke(Response $response): Response
    {
        $data = $this->reader->read();

        $response = $this->renderer->render($response, 'frontend/home/index', $data);

        return $response;
    }
}
