<?php declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Data\Post;
use App\Domain\Post\Repository\PostCreatorRepository;
use App\Factory\LoggerFactory;
use App\Support\Slug;
use Cake\Validation\Validator;
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
     * @var PostCreatorRepository
     */
    private PostCreatorRepository $repository;

    /**
     * @Injection
     * @var Validator
     */
    private Validator $validator;

    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory  Monolog logger
     * @param PostCreatorRepository $repository Post creator repository
     * @param Validator $validator CakePHP validator
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        PostCreatorRepository $repository,
        Validator $validator
    ) {
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
        $this->validator = $validator;
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
        $this->validate($formData);

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

        try {
            $this->repository->create($post);

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
