<?php

declare(strict_types=1);

namespace App\Domain\Dsgvo\Service;

use App\Domain\Dsgvo\Data\Dsgvo;
use App\Domain\Dsgvo\Exception\DsgvoValidationException;
use App\Domain\Dsgvo\Repository\DsgvoRepository;
use DateTimeImmutable;

final class DsgvoUpdater
{
    public function __construct(
        private DsgvoRepository $repository,
        private DsgvoValidator $validator,
    ) {
    }

    /**
     * @param array{details: string} $formData The form data.
     */
    public function update(array $formData): void
    {
        $errors = $this->validator->validate($formData);

        if ($errors !== []) {
            throw new DsgvoValidationException($errors);
        }

        $dsgvo = $this->transformDataToDsgvo($formData);

        $this->repository->update($dsgvo);
    }

    /**
     * @param array{details: string} $formData The form data.
     */
    public function transformDataToDsgvo(array $formData): Dsgvo
    {
        return new Dsgvo(
            details: $formData['details'],
            updatedAt: new DateTimeImmutable(),
        );
    }
}
