<?php

declare(strict_types=1);

namespace App\Actions\Supporter;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\ViewInterface;

final class NewSupporterAction
{
    /**
     * @Injection
     * @var ViewInterface
     */
    private ViewInterface $view;

    /**
     * The constructor.
     *
     * @param ViewInterface $view Renderer
     */
    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
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
        $response = $this->view->render($response, 'supporter/create', []);

        return $response;
    }
}
