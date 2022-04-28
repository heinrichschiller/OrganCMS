<?php

declare(strict_types=1);

namespace App\Actions\Donation;

use App\Domain\Donation\Service\SoundFinder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class SoundFinderAction
{
    private SoundFinder $finder;

    public function __construct(SoundFinder $finder)
    {
        $this->finder = $finder;
    }

    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $work = $args['work'];
        $register = $args['register'];

        $data = $this->finder->findAllBy($work, $register);

        $response
            ->getBody()
            ->write(
                (string) json_encode([
                    'sound' => $data
                ])
            );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
