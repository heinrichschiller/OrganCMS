<?php

declare(strict_types=1);

namespace App\Action\Backend\Donation;

use App\Domain\Donation\Service\DonationDetailsReader;
use App\Renderer\TemplateRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class DonationDetailsAction
{
    /**
     * @Injection
     * @var DonationDetailsReader
     */
    private DonationDetailsReader $reader;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var TemplateRenderer
     */
    private TemplateRenderer $renderer;

    /**
     * The constructor
     *
     * @param DonationDetailsReader $reader
     * @param SessionInterface $session
     * @param TemplateRenderer $renderer
     */
    public function __construct(
        DonationDetailsReader $reader,
        SessionInterface $session,
        TemplateRenderer $renderer
    ) {
        $this->reader = $reader;
        $this->session = $session;
        $this->renderer = $renderer;
    }

    /**
     * The invoker.
     *
     * @param Request $request Representation of an incoming, server-side HTTP request.
     * @param Response $response Representation of an outgoing, server-side response.
     * @param array<string> $args Get all of the route's parsed arguments.
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $isSuccess = false;
        $isError = false;
        $message = '';

        $donation = $this->reader->read();

        $flash = $this->session->getFlash();

        if ($flash->has('success')) {
            $isSuccess = true;
            $message = $flash->get('success')[0];
        }

        if ($flash->has('error')) {
            $isSuccess = true;
            $message = $flash->get('error')[0];
        }

        $flash->clear();
        
        $data = [
            'donation' => $donation,
            'isSuccess' => $isSuccess,
            'isError' => $isError,
            'message' => $message
        ];

        $response = $this->renderer->render($response, 'backend/donation/donation-board', $data);

        return $response;
    }
}
