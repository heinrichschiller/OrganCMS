<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Repository\PostUpdaterRepository;
use Cake\Validation\Validator;

final class PostUpdater
{
    private PostUpdaterRepository $repository;

    public function __construct(PostUpdaterRepository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function update(array $formData): void
    {
        $this->validate($formData);

        // workaround, sqlite column expects a string and not null
        if (null === $formData['author']) {
            $formData['author'] = 'heinrich';
        }

        // workaround, sqlite column expects a string and not null
        if (null === $formData['on_mainpage']) {
            $formData['on_mainpage'] = '';
        }

        // workaround, sqlite column expects a string and not null
        if (null === $formData['is_published']) {
            $formData['is_published'] = '';
        }

        $this->repository->update($formData);
    }

    public function validate(array $formData): void
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
