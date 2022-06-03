<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Event;
use App\Domain\Event\Repository\EventUpdaterRepository;
use Cake\Validation\Validator;

final class EventUpdater
{
    /**
     * @Injection
     * @var EventUpdaterRepository
     */
    private EventUpdaterRepository $repository;

    /**
     * @Injection
     * @var Validator
     */
    private Validator $validator;

    /**
     * The constructor.
     *
     * @param EventUpdaterRepository $repository
     * @param Validator $validator  CakePHP validator
     */
    public function __construct(EventUpdaterRepository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Validate data
     *
     * @param array<mixed> $data The form data
     */
    public function validate(array $formData): void
    {
        $this->validator
            ->requirePresence('title')
            ->notEmptyString('title', 'Der Titel darf nicht leer sein.')
            ->requirePresence('date')
            ->notEmptyDate('date', 'Das Datum darf nicht leer sein.');

        $errors = $this->validator->validate($formData);

        if ($errors) {
            foreach ($errors as $error) {
                foreach ($error as $value) {
                    echo "<p>$value</p>";
                }
            }

            die;
        }
    }

    /**
     * Update data
     *
     * @param array<mixed> $data The form data
     */
    public function update(array $formData): void
    {
        $this->validate($formData);

        $event = new Event;

        $event->setId((int) $formData['id']);
        $event->setTitle($formData['title']);
        $event->setPlace($formData['place']);
        $event->setEventDate($formData['date']);
        $event->setDesc($formData['desc']);
        $event->setPublished((bool) $formData['publish']);

        if ($formData['publish']) {
            $event->setPublishedOn(date("Y-d-m"));
        }

        $this->repository->update($event);
    }
}
