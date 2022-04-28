<?php

declare( strict_types = 1 );

namespace App\Actions\Pages;

use App\Domain\Donation\DonationBoard;
use App\Domain\Donation\Service\DonationBoardReader;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class IndexAction
{
    /**
     * @Injection
     * @var DonationBoard
     */
    private DonationBoard $donation;

    /**
     * @Injection
     * @var DonationBoardReader
     */
    private DonationBoardReader $reader;

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
     * @param ViewInterface $view
     */
    public function __construct(DonationBoard $donation, DonationBoardReader $reader, ViewInterface $view)
    {
        $this->donation = $donation;
        $this->reader = $reader;
        $this->view = $view;
    }

    /**
     * The invoker
     *
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $this->donation = $this->reader->read();

        $data = [
            'donation' => $this->donation
        ];

        $response = $this->view->render($response, 'index', $data);

        return $response;
    }
}
