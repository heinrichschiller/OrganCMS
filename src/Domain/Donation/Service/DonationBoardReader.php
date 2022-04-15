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

namespace App\Domain\Donation\Service;

use App\Domain\Donation\DonationBoard;
use App\Domain\Donation\Repository\DonationBoardReaderRepository;

final class DonationBoardReader
{
    /**
     * @Injection
     * @var DonationBoardReaderRepository
     */
    private DonationBoardReaderRepository $repository;

    /**
     * The constructor
     *
     * @param DonationBoardReaderRepository
     */
    public function __construct(DonationBoardReaderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Read donation status
     *
     * @return DonationBoard
     */
    public function read(): DonationBoard
    {
        return $this->repository->read();
    }
}
