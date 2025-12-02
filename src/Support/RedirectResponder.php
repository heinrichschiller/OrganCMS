<?php

declare(strict_types=1);

namespace App\Support;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Interfaces\RouteParserInterface;

final class RedirectResponder
{
    private RouteParserInterface $router;

    public function __construct(RouteParserInterface $router)
    {
        $this->router = $router;
    }

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
