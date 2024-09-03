<?php declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Data\Post;
use App\Domain\Post\Repository\PostRepository;
use App\Domain\Post\Service\PostValidator;
use App\Factory\LoggerFactory;
use App\Support\Slug;
use Error;
use Exception;
use Psr\Log\LoggerInterface;
use Selective\ArrayReader\ArrayReader;

final class PostCreator
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
     * @param LoggerFactory $loggerFactory  Monolog logger
     * @param PostRepository $repository Post creator repository
     * @param Validator $validator CakePHP validator
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        PostRepository $repository,
        PostValidator $postValidator
    ) {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
        $this->postValidator = $postValidator;
    }

    /**
     * Create a new post.
     *
     * @param array $formData The form data.
     *
     * @return bool
     */
    public function create(array $formData): bool
    {
        $this->validatePostCreate($formData);

        $post = $this->setPost($formData);

        try {
            $this->repository->createPost($post);

            return true;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostCreator->create(): %s", $e->getMessage()));

            return false;
        } catch (Error $e) {
            $this->logger->error(sprintf("PostCreator->create(): %s", $e->getMessage()));

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

        $title = $reader->findString('title');
        $slug = $this->slug($title);
        $intro = $reader->findString('intro');
        $content = $reader->findString('content');
        $authorId = $reader->findInt('author_id');
        $onMainpage = $reader->findBool('on_mainpage', false);
        $publishedAt = $reader->findChronos('published_at') ? date('Y-m-d H:i:s') : '';
        $publish = $reader->findBool('publish', false);
        $createdAt = date('Y-m-d H:i:s');

        $post = new Post(
            0,                         // placeholder
            $title,
            $slug,
            $intro,
            $content,
            $authorId,
            $onMainpage,
            $publishedAt,
            $publish,
            $createdAt,
            ''                         // updated at
        );

        return $post;
    }

    /**
     * Validate $formData
     *
     * @param array<mixed> $formData The form data.
     */
    private function validatePostCreate(array $formData): void
    {
        $this->postValidator->validatePost($formData);
    }
}
