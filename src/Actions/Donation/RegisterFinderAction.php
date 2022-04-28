<?php

declare(strict_types=1);

namespace App\Actions\Donation;

use App\Domain\Donation\Service\RegisterFinder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class RegisterFinderAction
{
    /**
     * @Injection
     * @var RegisterFinder
     */
    private RegisterFinder $finder;

    /**
     * The constructor.
     *
     * @param RegisterFinder $finder
     */
    public function __construct(RegisterFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * The invoker.
     *
     * @param Request $request
     * @param Response $response
     * @param array<mixed> $args
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $register = $args['register'];

        $data = $this->finder->findAll($register);

        $response
            ->getBody()
            ->write(
                (string) json_encode([
                    'register' => $data
                ])
            );
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
