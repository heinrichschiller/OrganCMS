<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Event;
use App\Domain\Event\Repository\EventCreatorRepository;
use App\Factory\LoggerFactory;
use Cake\Validation\Validator;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class EventCreator
{
    /**
     * @Injection
     * @var EventCreatorRepository
     */
    private EventCreatorRepository $repository;

    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Injection
     * @var Validator
     */
    private Validator $validator;

    /**
     * The contstructor.
     *
     * @param EventCreatorRepository $repository
     * @param LoggerFactory $loggerFactory
     * @param Validator $validator  CakePHP validator
     */
    public function __construct(
        EventCreatorRepository $repository,
        LoggerFactory $loggerFactory,
        Validator $validator
    ) {
        $this->repository = $repository;
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->validator = $validator;
    }

    /**
     * Create an event entry
     *
     * @param array<mixed> $formData
     *
     * @return bool
     */
    public function create(array $formData): bool
    {
        $this->validate($formData);

        if (!isset($formData['publish'])) {
            $formData['publish'] = '';
        }

        $isPublished = (bool) $formData['publish'];
        $publishedAt = $isPublished ? (string) date('Y-m-d H:i:s') : '';
        $createdAt = (string) date('Y-m-d H:i:s');

        $event = new Event(
            0,
            $formData['title'],
            $formData['place'],
            $formData['desc'],
            $formData['date'],
            (bool) $isPublished,
            $publishedAt,
            $createdAt
        );

        try {
            $this->repository->create($event);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventCreator->create(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventCreator->create(): %s", $e->getMessage()));
            
            return false;
        }
    }

    /**
     * Validate data
     *
     * @param array<mixed> $formData
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
}
