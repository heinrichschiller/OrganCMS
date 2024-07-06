<?php

declare(strict_types=1);

namespace App\Domain\Event\Service;

use App\Domain\Event\Data\Event;
use App\Domain\Event\Repository\EventUpdaterRepository;
use App\Factory\LoggerFactory;
use Cake\Validation\Validator;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class EventUpdater
{
    /**
     * @Injection
     * @var EventUpdaterRepository
     */
    private EventUpdaterRepository $repository;

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
     * The constructor.
     *
     * @param EventUpdaterRepository $repository
     * @param LoggerFactory $loggerFactory
     * @param Validator $validator  CakePHP validator
     */
    public function __construct(
        EventUpdaterRepository $repository,
        LoggerFactory $loggerFactory,
        Validator $validator
    ) {
        $this->repository = $repository;
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->validator = $validator;
    }

    /**
     * Update data
     *
     * @param array<mixed> $formData The form data
     *
     * @return bool
     */
    public function update(array $formData): bool
    {
        $this->validate($formData);

        if (!isset($formData['publish'])) {
            $formData['publish'] = '';
        }

        if ('on' === $formData['publish']) {
            $formData['publish'] = 1;
        }

        if (null === $formData['publish']) {
            $formData['publish'] = '';
        }
        
        $event = new Event(
            (int) $formData['id'],
            $formData['title'],
            $formData['place'],
            $formData['desc'],
            $formData['date'],
            (bool) $formData['publish'],
            date('Y-m-d H:i:s')
        );

        try {
            $this->repository->update($event);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("EventFinder->update(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("EventFinder->update(): %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * Validate data
     *
     * @param array<mixed> $formData The form data
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
