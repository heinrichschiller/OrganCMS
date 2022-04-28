<?php

declare(strict_types=1);

namespace App\Actions\Donation;

use App\Domain\Donation\Service\DonationCreator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class CreateAction
{
    private DonationCreator $creator;

    /**
     * The constructor.
     * 
     * @param DonationCreator $creator
     */
    public function __construct(DonationCreator $creator)
    {
        $this->creator = $creator;
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
        $formData = (array) $request->getParsedBody();

        $this->creator->create($formData);

        return $response;
    }
}