<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterCreatorRepository;
use App\Domain\Supporter\Data\Supporter;
use Cake\Validation\Validator;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class SupporterCreator
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Injection
     * @var SupporterCreatorRepository
     */
    private SupporterCreatorRepository $repository;

    /**
     * @Injection
     * @var Validator
     */
    private Validator $validator;

    /**
     * The constructor.
     *
     * @param SupporterCreatorRepository $repository Supporter creator repository
     * @param Validator $validator CakePHP validator
     */
    public function __construct(LoggerFactory $loggerFactory, SupporterCreatorRepository $repository, Validator $validator)
    {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Insert a new supporter into the database.
     *
     * @param array<mixed> $formData The form data.
     *
     * @return bool
     */
    public function insert(array $formData): bool
    {
        $this->validate($formData);

        if (!isset($formData['publish'])) {
            $formData['publish'] = '';
        }
        
        $title = $formData['title'];
        $isPublished = (bool) $formData['publish'];
        $publishedAt = $isPublished ? (string) date('Y-m-d H:i:s') : '';
        $createdAt = (string) date('Y-m-d H:i:s');
        $updatedAt = '';

        $supporter = new Supporter(
            null,
            $formData['title'],
            (bool) $isPublished,
            $publishedAt,
            $createdAt,
            $updatedAt
        );
        
        try {
            $this->repository->insert($supporter);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->create(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));

            return false;
        }
    }

    /**
     * Validate $formData
     *
     * @param array<mixed> $formData The form data.
     */
    private function validate(array $formData)
    {
        $this->validator
            ->requirePresence('title')
            ->notEmptyString('title', 'Der Titel darf nicht leer sein.');
        
        $errors = $this->validator->validate($formData);

        if ($errors) {
            foreach ($errors as $error) {
                dd($error);
            }
        }
    }
}
