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
            ->requirePresence('date')
            ->notEmptyDate('date', 'Das Datum darf nicht leer sein.')
            ->requirePresence('desc', 'Beschreibung darf nicht leer sein')
            ->notEmptyString('desc', 'Beschreibung darf nicht leer sein')
            ->requirePresence('id', true, 'Id nicht gefunden')
            ->notEmptyString('id', 'Id nicht gefunden.');

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
