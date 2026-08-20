<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use Cake\Validation\Validator;

final class SupporterValidator
{
    /**
     * @param array{
     *      id: string,
     *      name: string,
     *      publish?: string,
     *      published_at: string,
     *      created_at: string
     *  } $formData The form data
     */
    public function validateSupporter(array $formData): array
    {
        $validator = new Validator();

        $validator
            ->requirePresence('name')
            ->notEmptyString('name', 'Der Name darf nicht leer sein.');
        
        return $validator->validate($formData);
    }
}
