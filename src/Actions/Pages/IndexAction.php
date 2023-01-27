<?php

declare( strict_types = 1 );

namespace App\Actions\Pages;

use App\Domain\Page\Service\IndexReader;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class IndexAction
{
    /**
     * @Injection
     * @var IndexReader
     */
    private IndexReader $reader;

    /**
     * @Injection
     * @var ViewInterface
     */
    private ViewInterface $view;

    /**
     * The constructor
     *
     * @param DonationBoard $donation
     * @param DonationBoardReader $reader
     * @param PostFinder $postFinder
     * @param ViewInterface $view
     */
    public function __construct(
        IndexReader $reader,
        ViewInterface $view
    ) {
        $this->reader = $reader;
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
        $data = (array) $this->reader->read();

        $response = $this->view->render($response, 'index', $data);

        return $response;
    }
}
