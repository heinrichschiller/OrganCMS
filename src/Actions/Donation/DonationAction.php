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

use App\Domain\Donation\Service\DonationBoardReader;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\ViewInterface;

final class DonationAction
{
    /**
     * @Injection
     * @var DonationBoardReader
     */
    private DonationBoardReader $reader;

    /**
     * @Injection
     * @var SessionInterface
     */
    private SessionInterface $session;

    /**
     * @Injection
     * @var ViewInterface
     */
    private ViewInterface $view;

    /**
     * The constructor
     *
     * @param DonationBoardReader $reader
     * @param SessionInterface $session
     * @param ViewInterface $view
     */
    public function __construct(
        DonationBoardReader $reader,
        SessionInterface $session,
        ViewInterface $view
    ) {
        $this->reader = $reader;
        $this->session = $session;
        $this->view = $view;
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
        $isSuccess = false;
        $message = '';

        $donation = $this->reader->read();

        $flash = $this->session->getFlash();

        if($flash->has('success')) {
            $isSuccess = true;
            $message = $flash->get('success')[0];
        }
        $flash->clear();
        
        $data = [
            'donation' => $donation,
            'isSuccess' => $isSuccess,
            'message' => $message
        ];

        $response = $this->view->render($response, 'donation-board', $data);

        return $response;
    }
}
