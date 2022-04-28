<?php

declare(strict_types=1);

namespace App\Actions\Donation;

use App\Domain\Donation\Service\DonationBoardReader;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class DonationBoardAction
{
    /**
     * @Injection
     * @var DonationBoardReader
     */
    private DonationBoardReader $reader;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var ViewInterface
     */
    private ViewInterface $view;

    /**
     * The constructor
     *
     * @param DonationBoardReader $reader
     * @param SessionInterface $session
     * @param ViewInterface $view
     */
    public function __construct(
        DonationBoardReader $reader,
        SessionInterface $session,
        ViewInterface $view
    ) {
        $this->reader = $reader;
        $this->session = $session;
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
        $isSuccess = false;
        $message = '';

        $donation = $this->reader->read();

        $flash = $this->session->getFlash();

        if ($flash->has('success')) {
            $isSuccess = true;
            $message = $flash->get('success')[0];
        }
        $flash->clear();
        
        $data = [
            'donation' => $donation,
            'isSuccess' => $isSuccess,
            'message' => $message
        ];

        $response = $this->view->render($response, 'donation-board', $data);

        return $response;
    }
}
