<?php

declare(strict_types=1);

namespace App\Middleware\User;

use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Routing\RouteContext;

final class UserAuthMiddleware implements MiddlewareInterface
{
    /**
     * @Injection
     * @var ResponseFactoryInterface
     */
    private ResponseFactoryInterface $responseFactory;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * The constructor
     *
     * @param ResponseFactoryInterface $responseFactory
     * @param SessionInterface $session
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        SessionInterface $session
    ) {
        $this->responseFactory = $responseFactory;
        $this->session = $session;
    }

    /**
     * Process
     *
     * @param Request $request
     * @param Handler $handler
     *
     * @return Response
     */
    public function process(Request $request, Handler $handler): Response
    {
        if ($this->session->get('user')) {
            return $handler->handle($request);
        }

        // User is not logged in. Redirect to login page
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('organcms');

        return $this->responseFactory
            ->createResponse()
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
