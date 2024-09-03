<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use Cake\Validation\Validator;

class PostValidator
{
    /**
     * Validate data
     * 
     * @param array<string> $formData The form data
     */
    public function validatePost(array $formData): void
    {
        $validator = new Validator();

        $validator
            ->requirePresence('title')
            ->notEmptyString('title', 'Der Titel darf nicht leer sein.');
        
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