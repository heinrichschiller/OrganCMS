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

use App\Domain\Donation\Repository\DonationUpdaterRepository;

final class DonationUpdater
{
    /**
     * @Injection
     * @var DonationUpdaterRepository
     */
    private DonationUpdaterRepository $repository;

    /**
     * The constructor
     * 
     * @param DonationUpdaterRepository $repository
     */
    public function __construct(DonationUpdaterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Update donation status
     * 
     * @param string $total The total amount of donations
     * @param string $date  Month date
     * @param string $user  User who last update
     */
    public function update(string $total, string $date, string $user): void
    {
        $date = $this->formateDate($date);

        $this->repository->update($total, $date, $user);
    }

    private function formateDate(string $date): string
    {
        $datePieces = explode('-', $date);

        return sprintf('%s.%s.%s', $datePieces[2], $datePieces[1], $datePieces[0]);
    }
}
