<?php

declare(strict_types=1);

namespace App\Actions\News;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class IndexAction
{
    /**
     * @Injection
     * @var ViewInterface
     */
    private ViewInterface $view;

    /**
     * The constructor.
     * 
     * @param ViewInterface $view
     */
    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * The invoker.
     * 
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     * 
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $this->response = $this->view->render($response, 'news/index', []);

        return $this->response;
    }
}