<?php

declare(strict_types=1);

namespace App\Domain\Supporter\Service;

use App\Domain\Supporter\Repository\SupporterUpdaterRepository;
use App\Domain\Supporter\Supporter;
use Cake\Validation\Validator;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class SupporterUpdater
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

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
     * @param LoggerFactory $loggerFactory Monolog logger factory.
     * @param SupporterUpdaterRepository $updater Supporter updater repository
     * @param Validator $validator CakePHP validator
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        SupporterUpdaterRepository $updater,
        Validator $validator
    ) {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->updater = $updater;
        $this->validator = $validator;
    }

    /**
     * Update supporter entry.
     *
     * @param array<string> $formData The form data
     *
     * @return bool
     */
    public function update(array $formData): bool
    {
        if (!isset($formData['publish'])) {
            $formData['publish'] = '';
        }

        if ('on' === $formData['publish']) {
            $formData['publish'] = '1';
        }

        if (null === $formData['publish']) {
            $formData['publish'] = '';
        }

        $this->validator->validate($formData);

        $supporter = new Supporter(
            (int) $formData['id'],
            $formData['name'],
            (bool) $formData['publish'],
            $formData['published_at'],
            $formData['created_at'],
            date('Y-m-d H:i:s')
        );

        try {
            $this->updater->update($supporter);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("SupportFinder->update(): %s", $e->getMessage()));
            
            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));
            
            return false;
        }
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
