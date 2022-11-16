<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Domain\Donation\Service\DonationBoardReader;
use App\Domain\Event\Service\EventFinder;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class UserAction
{
    /**
     * @Injection
     * @var DonationBoardReader
     */
    private DonationBoardReader $reader;

    /**
     * @Injection
     * @var EventFinder
     */
    private EventFinder $finder;

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
     * @param SessionInterface $session
     * @param ViewInterface $view
     */
    public function __construct(
        DonationBoardReader $reader,
        EventFinder $finder,
        SessionInterface $session,
        ViewInterface $view
    ) {
        $this->reader = $reader;
        $this->finder = $finder;
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
        $username = $this->session->get('user');

        $donation = $this->reader->read();
        $event = $this->finder->findPublishedEvents();

        $data = [
            'user' => $username,
            'donation' => $donation,
            'event' => $event[0]
        ];

        $response = $this->view->render($response, 'dashboard', $data);

        return $response;
    }
}
