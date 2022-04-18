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

use App\Domain\Donation\Repository\SoundFinderRepository;

final class SoundFinder
{
    /**
     * @Injection
     * @var SoundFinderRepository
     */
    private SoundFinderRepository $repository;

    /**
     * The constructor.
     * 
     * @param SoundFinderRepository $repository
     */
    public function __construct(SoundFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Find all sounds by work and register name
     * 
     * @param string $work      Organ work
     * @param string $register  Organ register
     * 
     * @return array<Sound>     List of organ sounds
     */
    public function findAllBy(string $work, string $register): array
    {
        return $this->repository->findAllBy($work, $register);
    }
}