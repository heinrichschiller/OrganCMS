<?php

declare(strict_types=1);

namespace App\Handler;

use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;

/**
 * HTTP Exception Hander for Internal Server Error.
 *
 * The server has encountered a situation it does not know how to handle.
 * This error is generic, indicating that the server cannot find a more
 * appropriate 5XX status code to respond with.
 *
 */
final class HttpExceptionHandler implements ErrorHandlerInterface
{
    /**
     * The invoker.
     *
     * @param Request $request
     * @param Throwable $exception
     * @param bool $displayErrorDetails
     * @param bool $logErrors
     * @param bool $logErrorDetails
     *
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface {
        $response = new Response();

        $response->getBody()->write('<h1>500 Internal Server Error</h1>');

        return $response
            ->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
    }
}
