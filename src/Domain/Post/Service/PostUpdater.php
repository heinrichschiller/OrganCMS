<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Post;
use App\Domain\Post\Repository\PostUpdaterRepository;
use App\Factory\LoggerFactory;
use Cake\Validation\Validator;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

final class PostUpdater
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Injection
     * @var PostUpdaterRepository
     */
    private PostUpdaterRepository $repository;

    /**
     * @Injection
     * @var Validator
     */
    private Validator $validator;

    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory Monolog logger factory.
     * @param PostUpdaterRepository $repository Post updater repository
     * @param Validator $validator CakePHP validator
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        PostUpdaterRepository $repository,
        Validator $validator
    ) {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Update post entry.
     *
     * @param array<mixed> $formData The form data
     *
     * @return bool
     */
    public function update(array $formData): bool
    {
        $this->validate($formData);

        // workaround, sqlite column expects a string and not null
        if (!isset($formData['author'])) {
            $formData['author'] = 'heinrich';
        }

        // workaround, sqlite column expects a string and not null
        if (null === $formData['on_mainpage']) {
            $formData['on_mainpage'] = '';
        }

        // workaround, sqlite column expects a string and not null
        if (isset($formData['is_published'])) {
            $formData['is_published'] = '1';
        }

        $slug = $this->slug($formData['title']);

        $post = new Post(
            (int) $formData['id'],
            $formData['title'],
            $slug,
            $formData['content'],
            $formData['author'],
            (bool) $formData['on_mainpage'],
            $formData['published_at'],
            (bool) $formData['is_published'],
            $formData['created_at'],
            $formData['updated_at'],
        );

        try {
            $this->repository->update($post);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->update(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("PostFinder->update(): %s", $e->getMessage()));
            
            return false;
        }
    }

    /**
     * Create a slug by a post title.
     *
     * @param string $title Post title
     *
     * @return string
     */
    private function slug(string $title): string
    {
        $text = str_replace(['\'', '"', '?', '!'], '', $title);
        $text = str_replace(' ', '-', $text);
        $text = $text . '.html';

        return strtolower($text);
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
