<?php

declare(strict_types=1);

namespace App\Domain\Dsgvo\Service;

use Cake\Validation\Validator;

final class DsgvoValidator
{
    /**
     * @param array{details: string} $formData The form data.
     *
     * @return array<mixed>
     */
    public function validate(array $formData): array
    {
        $validator = new Validator();

        $validator
            ->requirePresence('details')
            ->notEmptyString(
                'details',
                'Beschreibung darf nicht leer sein.'
            );
        
        return $validator->validate($formData);
    }
}
