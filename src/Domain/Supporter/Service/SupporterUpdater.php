<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterUpdaterRepository;
use Cake\Validation\Validator;

final class SupporterUpdater
{
    /**
     * @Injection
     * @var SupporterUpdaterRepository
     */
    private SupporterUpdaterRepository $updater;

    /**
     * @Injection
     * @var Validator
     */
    private Validator $validator;

    /**
     * The constructor.
     *
     * @param SupporterUpdaterRepository $updater Supporter updater repository
     * @param Validator $validator CakePHP validator
     */
    public function __construct(SupporterUpdaterRepository $updater, Validator $validator)
    {
        $this->updater = $updater;
        $this->validator = $validator;
    }

    /**
     * Update supporter entry.
     *
     * @param array<mixed> $formData The form data
     *
     * @return void
     */
    public function update(array $formData): void
    {
        $this->validator->validate($formData);

        if ('on' === $formData['publish']) {
            $formData['publish'] = 1;
        }

        if (null === $formData['publish']) {
            $formData['publish'] = '';
        }

        $this->updater->update($formData);
    }

    /**
     * Validate the form data.
     *
     * @param array<mixed> $formData The form data.
     *
     * @return void
     */
    public function validate(array $formData): void
    {
        $this->validator
            ->requirePresence('name')
            ->notEmptyString('name', 'Der Name darf nicht leer sein.');
    
        $errors = $this->validator->validate($formData);

        if ($errors) {
            foreach ($errors as $error) {
                dd($error);
            }
        }
    }
}
