<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterRepository;

final class SupporterDeleter
{
    public function __construct(
        private SupporterRepository $repository
    ) {
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}
