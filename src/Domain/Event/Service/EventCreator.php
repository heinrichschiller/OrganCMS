<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Event;
use App\Domain\Event\Repository\EventCreatorRepository;
use Cake\Validation\Validator;

final class EventCreator
{
    /**
     * @Injection
     * @var EventCreatorRepository
     */
    private EventCreatorRepository $repository;

    /**
     * @Injection
     * @var Validator
     */
    private Validator $validator;

    /**
     * The contstructor.
     * 
     * @param EventCreatorRepository $repository
     * @param Validator $validator  CakePHP validator
     */
    public function __construct(EventCreatorRepository $repository, Validator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Validate data
     * 
     * @param <array>mixed $formData    
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
            foreach($errors as $error) {
                foreach ($error as $value) {
                    echo "<p>$value</p>";
                }
            }

            die;
        }
    }

    /**
     * Create an event entry
     * 
     * @param array<mixed> $formData
     */
    public function create(array $formData): void
    {
        $this->validate($formData);

        $event = new Event;

        $event->setTitle($formData['title']);
        $event->setPlace($formData['place']);
        $event->setEventDate($formData['date']);
        $event->setDesc($formData['desc']);
        $event->setPublished((bool) $formData['publish']);

        if ($formData['publish']) {
            $event->setPublishedOn(date("d.m.Y"));
        }

        $this->repository->create($event);
    }
}