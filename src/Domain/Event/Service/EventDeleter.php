<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Exception\EventNotFoundException;
use App\Domain\Event\Repository\EventRepository;

final class EventDeleter
{
    public function __construct(
        private EventRepository $repository
    ) {
    }

    public function delete(int $id): void
    {
        $id = (int) $this->validateEventId($id);

        if ($id >= 0) {
            $this->repository->delete($id);
        }
    }

    public function validateEventId(int $id): int
    {
        if (!$this->repository->existsEventId($id)) {
            throw new EventNotFoundException($id);
        }

        return $id;
    }
}
