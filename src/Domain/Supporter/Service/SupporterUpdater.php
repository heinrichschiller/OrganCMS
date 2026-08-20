<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterRepository;
use App\Domain\Supporter\Data\Supporter;
use App\Domain\Supporter\Exception\SupporterValidationException;
use DateTimeImmutable;
use DomainException;
use Selective\ArrayReader\ArrayReader;

final class SupporterUpdater
{
    public function __construct(
        private SupporterRepository $repository,
        private SupporterValidator $supporterValidator,
    ) {
    }

    /**
     * @param array{
     *      id: string,
     *      name: string,
     *      publish?: string,
     *      published_at: string,
     *      created_at: string
     *  } $formData
     */
    public function update(int $id, array $formData): void
    {
        $errors = $this->validateSupporterUpdate($id, $formData);

        if ($errors !== []) {
            throw new SupporterValidationException($errors);
        }
        
        $supporter = $this->transformDataToSupporter($id, $formData);

        $this->repository->update($supporter);
    }

    private function transformDataToSupporter(int $id, array $formData): Supporter
    {
        $reader = new ArrayReader($formData);

        $supporter = new Supporter(
            id: $id,
            name: $reader->findString('name'),
            isPublished: $reader->findBool('publish') ? true : false,
            publishedAt: $reader->findChronos('published_at'),
            createdAt: $reader->findChronos('created_at'),
            updatedAt: new DateTimeImmutable()
        );

        return $supporter;
    }

    /**
     * @param array{
     *      id: string,
     *      name: string,
     *      publish?: string,
     *      published_at: string,
     *      created_at: string
     *  } $formData The form data
     *
     * @return array<mixed>
     */
    public function validateSupporterUpdate(int $id, array $formData): array
    {
        if (!$this->repository->existsSupporterId($id)) {
            throw new DomainException(sprintf(
                'Event nicht gefunden: %s',
                $id
            ));
        }
        
        return $this->supporterValidator->validateSupporter($formData);
    }
}
