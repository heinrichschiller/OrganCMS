<?php

/**
 * MIT License
 *
 * Copyright (c) 2022 Heinrich Schiller
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

declare(strict_types=1);

namespace App\Actions\Donation;

use App\Domain\Donation\Service\DonationUpdater;
use App\Domain\Donation\Service\FileUploader;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;

final class DonationUpdateAction
{
    /**
     * @Injection
     * @var DonationUpdater
     */
    private DonationUpdater $updater;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var FileUploader
     */
    private FileUploader $uploader;

    /**
     * The constructor
     * 
     * @param DonationUpdater $updater
     * @param SessionInterface $session
     * @param FileUploader $uploader
     */
    public function __construct(
        DonationUpdater $updater,
        SessionInterface $session,
        FileUploader $uploader
    ) {
        $this->updater = $updater;
        $this->session = $session;
        $this->uploader = $uploader;
    }

    /**
     * The invoker
     * 
     * @param Request $request
     * @param Response $response 
     * @param array<mixed> $args
     * 
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $username = $this->session->get('user');
        
        $data = $request->getParsedBody();

        $total = (string) ($data['total'] ?? '');
        $date = (string) ($data['date'] ?? '');

        $this->updater->update($total, $date, $username);

        $uploadedFiles = $request->getUploadedFiles();
        $this->uploader->upload($uploadedFiles);

        $flash = $this->session->getFlash();
        $flash->clear();

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('users');

        return $response
            ->withStatus(302)
            ->withHeader('Location', $url);
    }
}
