<?php

declare(strict_types=1);

namespace App\Support;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Interfaces\RouteParserInterface;

final class RedirectResponder
{
    public function __construct(
        private RouteParserInterface $router
    ) {
    }

    /**
     * @param array<mixed> $routeArgs
     * @param array<mixed> $queryParams
     */
    public function toRoute(
        Response $response,
        string $routeName,
        array $routeArgs = [],
        array $queryParams = [],
        int $status = 303
    ): Response {
        $url = $this->router->urlFor($routeName, $routeArgs, $queryParams);

        return $response
            ->withStatus($status)
            ->withHeader('Location', $url);
    }
}
