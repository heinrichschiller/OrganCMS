<?php

declare(strict_types=1);

namespace App\Action\Backend\Dsgvo;

use App\Domain\Dsgvo\Exception\DsgvoValidationException;
use App\Domain\Dsgvo\Service\DsgvoUpdater;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class UpdateAction
{
    public function __construct(
        private CustomFlash $flash,
        private DsgvoUpdater $updater,
        private RedirectResponder $responder,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $formData = (array) $request->getParsedBody();

        try {
            $this->updater->update($formData);

            $this->flash->success('Erfolgreich aktualisiert.');

            return $this->responder->toRoute($response, 'dsgvo');
        } catch (DsgvoValidationException $e) {
            $message = $e->getMessages();
            $this->flash->error($message[0]);

            return $this->responder->toRoute($response, 'dsgvo');
        }
    }
}
