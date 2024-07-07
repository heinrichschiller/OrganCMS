<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Data\Post;
use App\Domain\Post\Repository\PostUpdaterRepository;
use App\Factory\LoggerFactory;
use App\Support\Slug;
use Cake\Validation\Validator;
use Error;
use Exception;
use Psr\Log\LoggerInterface;
use Selective\ArrayReader\ArrayReader;

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

        $reader = new ArrayReader($formData);
        
        $id = $reader->findInt('id');
        $title = $reader->findString('title');
        $slug = $this->slug($formData['title']);
        $intro = $reader->findString('intro');
        $content = $reader->findString('content');
        $authorId = $reader->findInt('author_id');
        $onMainpage = $reader->findBool('on_mainpage');
        $isPublished = $reader->findBool('is_published');
        $createdAt = $reader->findString('created_at');
        $updatedAt = date('Y-m-d H:i:s');

        if ($isPublished)
            $publishedAt = date('Y-m-d H:i:s');

        $post = new Post(
            $id,
            $title,
            $slug,
            $intro,
            $content,
            $authorId,
            $onMainpage,
            $publishedAt,
            $isPublished,
            $createdAt,
            $updatedAt
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
