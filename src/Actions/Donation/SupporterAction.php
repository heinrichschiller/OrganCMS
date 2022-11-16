<?php

declare(strict_types=1);

namespace App\Actions\Donation;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class SupporterAction
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
     * @param array<string> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $response = $this->view->render($response, 'supporter', []);

        return $response;
    }
}
