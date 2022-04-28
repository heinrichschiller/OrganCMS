<?php

declare(strict_types=1);

namespace App\Actions\Donation;

use App\Domain\Donation\Service\DonationUpdater;
use App\Domain\Donation\Service\FileUploader;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class DonationUpdateAction
{
    /**
     * @Injection
     * @var DonationUpdater
     */
    private DonationUpdater $updater;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var FileUploader
     */
    private FileUploader $uploader;

    /**
     * The constructor
     *
     * @param DonationUpdater $updater
     * @param SessionInterface $session
     * @param FileUploader $uploader
     */
    public function __construct(
        DonationUpdater $updater,
        SessionInterface $session,
        FileUploader $uploader
    ) {
        $this->updater = $updater;
        $this->session = $session;
        $this->uploader = $uploader;
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
        
        $data = $request->getParsedBody();

        $total = (string) ($data['total'] ?? '');
        $date = (string) ($data['date'] ?? '');

        $this->updater->update($total, $date, $username);

        $uploadedFiles = $request->getUploadedFiles();
        $this->uploader->upload($uploadedFiles);

        $flash = $this->session->getFlash();
        $flash->clear();

        $flash->add('success', 'Daten erfolgreich aktualisiert.');

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('donation');

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
