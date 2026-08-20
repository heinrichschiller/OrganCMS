<?php

declare(strict_types=1);

namespace App\Action\Backend\Supporter;

use App\Domain\Supporter\Service\SupporterCreator;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use DomainException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class CreateAction
{
    public function __construct(
        private SupporterCreator $creator,
        private CustomFlash $flash,
        private RedirectResponder $responder,
    ) {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $formData = (array) $request->getParsedBody();
        
        try {
            $this->creator->insert($formData);

            $this->flash->success('Eintrag erfolgreich angelegt.');

            return $this->responder->toRoute($response, 'supporter');
        } catch (DomainException $e) {
            $this->flash->error('Der Eintrag konnte nicht gespeichert werden.');

            return $this->responder->toRoute($response, 'new-supporter');
        } catch (Throwable $e) {
            $this->flash->error('Unerwarteter Fehler');

            return $this->responder->toRoute($response, 'new-supporter');
        }
    }
}
