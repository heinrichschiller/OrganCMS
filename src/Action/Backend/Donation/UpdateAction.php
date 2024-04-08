<?php

declare(strict_types=1);

namespace App\Action\Donation;

use App\Domain\Donation\Service\DonationUpdater;
use Fig\Http\Message\StatusCodeInterface;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class UpdateAction
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
     * The constructor
     *
     * @param DonationUpdater $updater Donation updater service.
     * @param SessionInterface $session Odan session interface.
     */
    public function __construct(DonationUpdater $updater, SessionInterface $session)
    {
        $this->updater = $updater;
        $this->session = $session;
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
        $formData = (array) $request->getParsedBody();

        $username = $this->session->get('user');
        $uploadedFiles = (array) $request->getUploadedFiles();

        $isUpdated = $this->updater->update($formData, $username);
        $isUploaded = $this->updater->uploadFiles($uploadedFiles);

        $flash = $this->session->getFlash();
        $flash->clear();

        $updateStatusKey = 'success';
        $updateStatusMessage = 'Eintrag erfolgreich aktualisiert.';
        if (!$isUpdated) {
            $updateStatusKey = 'error';
            $updateStatusMessage = 'Es ist ein Fehler aufgetretten. Der Eintrag konnte nicht aktualisiert werden.';
        }
        $flash->add($updateStatusKey, $updateStatusMessage);

        $uploadStatusKey = 'success';
        $uploadStatusMessage = 'Eintrag erfolgreich aktualisiert.';
        if (!$isUploaded) {
            $uploadStatusKey = 'error';
            $uploadStatusMessage = 'Es ist ein Fehler aufgetretten. Der Eintrag konnte nicht aktualisiert werden.';
        }
        $flash->add($uploadStatusKey, $uploadStatusMessage);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('donation');

        return $response
            ->withStatus(StatusCodeInterface::STATUS_FOUND)
            ->withHeader('Location', $url);
    }
}
