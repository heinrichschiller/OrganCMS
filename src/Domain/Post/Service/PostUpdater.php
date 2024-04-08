<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Post;
use App\Domain\Post\Repository\PostUpdaterRepository;
use App\Factory\LoggerFactory;
use App\Support\Slug;
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
     * @param array<string> $formData The form data
     *
     * @return bool
     */
    public function update(array $formData): bool
    {
        $this->validate($formData);

        if (!isset($formData['author'])) {
            $formData['author'] = 'heinrich';
        }

        if (!isset($formData['on_mainpage'])) {
            $formData['on_mainpage'] = '';
        }

        if (!isset($formData['is_published'])) {
            $formData['is_published'] = '';
        }

        if ('on' === $formData['is_published']) {
            $formData['is_published'] = '1';
        }

        if (null === $formData['is_published']) {
            $formData['is_published'] = '';
        }

        $slug = $this->slug($formData['title']);

        $post = new Post(
            (int) $formData['id'],
            $formData['title'],
            $slug,
            $formData['intro'],
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
        $slug = new Slug('german');

        $slugify = $slug->slugify($title);

        return $slugify . '.html';
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
