<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Data\Post;
use App\Domain\Post\Repository\PostRepository;
use App\Domain\Post\Service\PostValidator;
use App\Factory\LoggerFactory;
use App\Support\Slug;
use DomainException;
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
     * @var PostRepository
     */
    private PostRepository $repository;

    /**
     * @Injection
     * @var PostValidator
     */
    private PostValidator $postValidator;

    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory Monolog logger factory.
     * @param PostRepository $repository Post repository
     * @param Validator $validator CakePHP validator
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        PostRepository $repository,
        PostValidator $postValidator
    ) {
        $this->logger = $loggerFactory->addFileHandler('post_updater.log')->createLogger();
        $this->repository = $repository;
        $this->postValidator = $postValidator;
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
        $this->validatePostUpdate($formData);

        $post = $this->setPost($formData);

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
     * Create a post object from form data.
     * 
     * @param array<string> $formData The form data.
     * 
     * @return Post
     */
    private function setPost(array $formData): Post
    {
        $reader = new ArrayReader($formData);
        
        $id = $reader->findInt('id');
        $title = $reader->findString('title');
        $intro = $reader->findString('intro');
        $content = $reader->findString('content');
        $authorId = $reader->findInt('author_id');
        $onMainpage = $reader->findBool('on_mainpage');
        $isPublished = $reader->findBool('is_published');
        $createdAt = $reader->findString('created_at');

        $slug = $this->slug($title);

        $publishedAt = '';
        if ($isPublished)
            $publishedAt = date('Y-m-d H:i:s');

        $updatedAt = date('Y-m-d H:i:s');

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

        return $post;
    }

    /**
     * Validate data
     * 
     * @param array<string> $formData The form data
     */
    public function validatePostUpdate(array $formData): void
    {
        $postId = (int) $formData['id'];

        if (!$this->repository->existsPostId($postId)) {
            throw new DomainException(sprintf('Post nicht gefunden: %s', $postId));
        }

        $this->postValidator->validatePost($formData);
    }
}
