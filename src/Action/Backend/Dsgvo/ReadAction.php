<?php

declare(strict_types=1);

namespace App\Action\Backend\Dsgvo;

use App\Domain\Dsgvo\Data\Dsgvo;
use App\Domain\Dsgvo\Service\DsgvoFinder;
use App\Factory\LoggerFactory;
use App\Renderer\TemplateRenderer;
use App\Support\CustomFlash;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Throwable;

final class ReadAction
{
    private LoggerInterface $logger;

    public function __construct(
        private DsgvoFinder $finder,
        private CustomFlash $flash,
        private TemplateRenderer $renderer,
        LoggerFactory $loggerFactory,
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('dsgvo-read-error.log')
            ->createLogger();
    }

    public function __invoke(Response $response): Response
    {
        try {
            $dsgvo = $this->finder->find();
        } catch (Throwable $t) {
            $this->logger->error(
                'Die Dsgvo-Daten konnten nicht gelesen werden.',
                [
                    'exception' => $t,
                ]
            );

            $this->flash->error(
                'Die DSGVO-Daten konnten nicht geladen werden.'
            );

            $dsgvo = new Dsgvo();
        }

        $response = $this->renderer->renderBackend(
            $response,
            'admin/dsgvo/read',
            [
                'dsgvo' => $dsgvo,
                'flash' => $this->flash->readStatus()
            ]
        );
        
        return $response;
    }
}
