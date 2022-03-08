<?php

declare(strict_types=1);

namespace App\Error\Renderer;

use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

class HtmlErrorRenderer implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        return 'URL unbekannt';
    }
}
