<?php

declare(strict_types=1);

namespace App\Action\Backend\Supporter;

use App\Domain\Supporter\Service\SupporterFinder;
use App\Renderer\TemplateRenderer;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ReadAction
{
    /**
     * @Injection
     * @var SupporterFinder
     */
    private SupporterFinder $finder;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor
     *
     * @param SupporterFinder $finder
     * @param TemplateRenderer $renderer
     */
    public function __construct(SupporterFinder $finder, TemplateRenderer $renderer)
    {
        $this->finder = $finder;
        $this->renderer = $renderer;
    }

    /**
     * The invoker
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     * @param array<string> $args Get all of the route's parsed arguments.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $id = (int) $args['id'];
        $supporter  = $this->finder->findById($id);

        $data = [
            'supporter' => $supporter
        ];

        $response = $this->renderer->render($response, 'backend/supporter/edit', $data);

        return $response;
    }
}
