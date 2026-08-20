<?php

declare(strict_types=1);

namespace App\Domain\Dsgvo\Service;

use App\Domain\Dsgvo\Data\Dsgvo;
use App\Domain\Dsgvo\Exception\DsgvoNotFoundException;
use App\Domain\Dsgvo\Repository\DsgvoFinderRepository;
use DateTimeImmutable;

final class DsgvoFinder
{
    public function __construct(
        private DsgvoFinderRepository $repository,
    ) {
    }

    public function find(): Dsgvo
    {
        $dsgvoItem = $this->repository->find();

        if ($dsgvoItem === []) {
            throw new DsgvoNotFoundException();
        }
        
        $dsgvo = $this->transformDataToDsgvo($dsgvoItem);

        return $dsgvo;
    }

    /**
     * @param array{
     *      details?: string|null,
     *      updated_at?: string|null
     * } $data
     */
    private function transformDataToDsgvo(array $data): Dsgvo
    {
        if ($data === []) {
            return new Dsgvo;
        }

        return new Dsgvo(
            details: $data['details'] ?? null,
            updatedAt: $this->parseDate($data['updated_at'] ?? null)
        );
    }

    private function parseDate(?string $date): ?DateTimeImmutable
    {
        if ($date === null || $date === '') {
            return null;
        }

        return new DateTimeImmutable($date);
    }
}
