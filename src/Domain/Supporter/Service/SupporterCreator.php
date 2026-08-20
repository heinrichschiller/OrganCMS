<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterRepository;
use App\Domain\Supporter\Data\Supporter;
use App\Domain\Supporter\Exception\SupporterAlreadyExistsException;
use App\Domain\Supporter\Exception\SupporterValidationException;
use App\Domain\Supporter\Repository\SupporterFinderRepository;
use DateTimeImmutable;
use Selective\ArrayReader\ArrayReader;

final class SupporterCreator
{
    public function __construct(
        private SupporterRepository $repository,
        private SupporterFinderRepository $finder,
        private SupporterValidator $validator
    ) {
    }

    public function create(array $formData): void
    {
        $errors = $this->validateSupporterCreate($formData);

        if ($errors !== []) {
            throw new SupporterValidationException($errors);
        }
        
        $supporter = $this->transformDataToSupporter($formData);
        
        $this->repository->insert($supporter);
    }

    private function transformDataToSupporter(array $formData): Supporter
    {
        $reader = new ArrayReader($formData);

        $supporter = new Supporter(
            name: $reader->findString('name'),
            isPublished: $reader->findBool('publish') ? true : false,
            publishedAt: $reader->findChronos('published_at'),
            createdAt: new DateTimeImmutable(),
        );

        return $supporter;
    }

    private function validateSupporterCreate(array $formData)
    {
        if ($this->finder->findByName($formData['title'])) {
            throw new SupporterAlreadyExistsException($formData['title']);
        }
        
        return $this->validator->validateSupporter($formData);
    }
}
