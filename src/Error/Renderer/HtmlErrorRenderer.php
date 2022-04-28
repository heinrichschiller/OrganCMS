<?php

declare(strict_types=1);

namespace App\Error\Renderer;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class HtmlErrorRenderer implements ErrorRendererInterface
{
    /**
     * The invoker
     *
     * @param Throwable $exception,
     * @param bool $displayErrorDetails
     *
     * @return string
     */
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        return 'URL unbekannt';
    }
}
