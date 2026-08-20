<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use Cake\Validation\Validator;

final class EventValidator
{
    /**
     * @param array<mixed> $formData The form data
     *
     * @return array<mixed>
     */
    public function validateEvent(array $formData): array
    {
        $validator = new Validator();

        $validator
            ->requirePresence(['title', 'event_date', 'content'], true)
            ->notEmptyString(
                'title',
                'Der Titel darf nicht leer sein.'
            )
            ->minLength(
                'title',
                5,
                'Der Titel muss min. 5 Zeichen lang sein'
            )
            ->notEmptyDate(
                'event_date',
                'Das Datum darf nicht leer sein.'
            );

        return $validator->validate($formData);
    }
}
