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

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserUpdaterRepository;

final class UserUpdater
{
    /**
     * @var UserUpdaterRepository
     */
    private UserUpdaterRepository $repository;

    /**
     * The constructor
     *
     * @param UserUpdaterRepository $repository
     */
    public function __construct(UserUpdaterRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Update user
     *
     * @param string $identity      User identifier (username, email, etc)
     * @param string $credentials   User password
     */
    public function update(string $identity, string $credentials): void
    {
        $this->repository->update($identity, $credentials);
    }

    /**
     * Return user update status
     *
     * @return bool
     */
    public function isUpdated(): bool
    {
        return $this->repository->isUpdated();
    }
}
