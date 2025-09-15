<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use Cake\Validation\Validator;

final class EventValidator
{
    /**
     * Validate data
     *
     * @param array<mixed> $formData The form data
     */
    public function validateEvent(array $formData): void
    {
        $validator = new Validator();

        $validator->requirePresence('title')
            ->requirePresence('title', true, 'Der Titel darf nicht leer sein.')
            ->notEmptyString('title', 'Der Titel darf nicht leer sein.')
            ->minLength('title', 5, 'Der Titel muss min 5 Zeichen lang sein')
            ->allowEmptyString('place')
            ->requirePresence('event_date')
            ->notEmptyDate('event_date', 'Das Datum darf nicht leer sein.')
            ->requirePresence('content', 'Beschreibung darf nicht leer sein')
            ->notEmptyString('content', 'Beschreibung darf nicht leer sein');

        $errors = $validator->validate($formData);

        if ($errors) {
            foreach ($errors as $error) {
                foreach ($error as $value) {
                    echo "<p>$value</p>";
                }
            }

            die;
        }
    }
}
