<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterCreatorRepository;
use App\Domain\Supporter\Supporter;
use Cake\Validation\Validator;

final class SupporterCreator
{
    /**
     * @Injection
     * @var SupporterCreatorRepositor
     */
    private SupporterCreatorRepository $repository;

    /**
     * @Injection
     * @var Validator
     */
    private Validator $validator;

    /**
     * The constructor.
     * 
     * @param SupporterCreatorRepository $repository Supporter creator repository
     * @param Validator $validator CakePHP validator
     */
    public function __construct(SupporterCreatorRepository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Insert a new supporter into the database.
     * 
     * @param array<mixed> $formData The form data.
     */
    public function insert(array $formData)
    {
        $this->validate($formData);

        $title = $formData['title'];
        $isPublished = (bool) $formData['publish'];
        $publishedAt = $isPublished ? (string) date('Y-m-d H:i:s') : '';
        $createdAt = (string) date('Y-m-d H:i:s');
        $updatedAt = '';

        $supporter = new Supporter(
            0,
            $title,
            $isPublished,
            $publishedAt,
            $createdAt,
            $updatedAt
        );

        $this->repository->insert($supporter);
    }

    /**
     * Validate $formData
     * 
     * @param array<mixed> $formData The form data.
     */
    private function validate(array $formData)
    {
        $this->validator
            ->requirePresence('title')
            ->notEmptyString('title', 'Der Titel darf nicht leer sein.');
        
        $errors = $this->validator->validate($formData);

        if ($errors) {
            foreach ($errors as $error) {
                dd($error);
            }
        }
    }
}
