<?php

declare(strict_types=1);

namespace App\Actions\Donation;

use App\Domain\Donation\Service\WorkFinder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class WorkFinderAction
{
    /**
     * @Injection
     * @var WorkFinder $finder
     */
    private WorkFinder $finder;

    /**
     * The constructor.
     *
     * @param WorkFinder $finder Work finder service
     */
    public function __construct(WorkFinder $finder)
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
        $data = $this->finder->findAll();

        $response
            ->getBody()
            ->write(
                (string) json_encode([
                    'work' => $data
                ])
            );

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
