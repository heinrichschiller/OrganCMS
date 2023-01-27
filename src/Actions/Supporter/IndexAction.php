<?php

declare(strict_types=1);

namespace App\Actions\Supporter;

use App\Domain\Supporter\Service\SupporterFinder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class IndexAction
{
    private SupporterFinder $finder;

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
    public function __construct(SupporterFinder $finder, ViewInterface $view)
    {
        $this->finder = $finder;
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
        $collection = $this->finder->findAll();

        $data = [
            'supporters' => $collection
        ];

        $response = $this->view->render($response, 'supporter/index', $data);

        return $response;
    }
}
