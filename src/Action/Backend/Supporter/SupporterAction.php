<?php

declare(strict_types=1);

namespace App\Action\Backend\Supporter;

use App\Domain\Exception\DomainRecordNotFoundException;
use App\Domain\Supporter\Service\SupporterFinder;
use App\Factory\LoggerFactory;
use App\Renderer\TemplateRenderer;
use App\Support\CustomFlash;
use App\Support\RedirectResponder;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

final class SupporterAction
{
    private LoggerInterface $logger;

    public function __construct(
        private CustomFlash $flash,
        private SupporterFinder $finder,
        private TemplateRenderer $renderer,
        private RedirectResponder $responder,
        LoggerFactory $loggerFactory
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('supporter-all-error.log')
            ->createLogger();
    }

    public function __invoke(Response $response): Response
    {
        try {
            $supporters = $this->finder->findAll();

            $data = [
                'supporters' => $supporters,
                'flash' => $this->flash->readStatus()
            ];

            return $this->renderer->renderBackend(
                $response,
                'admin/supporter/index',
                $data
            );
        } catch (DomainRecordNotFoundException $e) {
            $this->logger->error(
                'Supporter mit dem Namen existiert bereits.',
                [
                    'exception' => $e
                ]
            );

            $this->flash->error($e->getMessage());

            return $this->responder->toRoute(
                $response,
                'supporters',
                [],
                [],
                StatusCodeInterface::STATUS_SEE_OTHER
            );
        }

    }
}
