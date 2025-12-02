<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Data\Post;
use App\Domain\Post\Data\PostCollection;
use App\Domain\Post\Repository\PostFinderRepository;
use App\Factory\LoggerFactory;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use Throwable;

final class PostFinder
{
    /**
     * @Injection
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @Injection
     * @var PostFinderRepository
     */
    private PostFinderRepository $repository;

    /**
     * The constructor.
     *
     * @param LoggerFactory $loggerFactory
     * @param PostFinderRepository $repository Post finder repository
     */
    public function __construct(
        LoggerFactory $loggerFactory,
        PostFinderRepository $repository
    ) {
        $this->logger = $loggerFactory
            ->addFileHandler('post-finder-error.log')
            ->createLogger();
        
        $this->repository = $repository;
    }

    /**
     * Find a post by id.
     *
     * @param int $id Post id.
     *
     * @return Post
     */
    public function findById(int $id): Post
    {
        $postItem = (array) $this->repository->findById($id);

        $result = $this->transformDataToPost($postItem);

        return $result;
    }

    /**
     * Find all posts or fail.
     *
     * @return PostCollection
     */
    public function findAll(): PostCollection
    {
        $postItems = (array) $this->repository->findAll();

        $collection = new PostCollection;
        foreach ($postItems as $postItem) {
            $result = $this->transformDataToPost($postItem);

            $collection->add($result);
        }

        return $collection;
    }

    /**
     * Find all public posts.
     *
     * @return PostCollection
     */
    public function findAllPublicPosts(): PostCollection
    {
        $postItems = $this->repository->findAllPublicPosts();

        $collection = new PostCollection;
        foreach ($postItems as $postItem) {
            $post = $this->transformDataToPost($postItem);

            $collection->add($post);
        }

        return $collection;
    }
    
    /**
     * Find post for the mainpage.
     *
     * @return Post
     */
    public function findMainpagePost(): Post
    {
        $postItem = (array) $this->repository->findMainpagePost();

        $post = $this->transformDataToPost($postItem);

        return $post;
    }

    /**
     * Find all mainpage posts
     *
     * @param int $limit Limit
     *
     * @return PostCollection
     */
    public function findAllMainpagePosts(int $limit): PostCollection
    {
        $postItems = (array) $this->repository->findAllMainpagePosts($limit);

        $collection = new PostCollection;
        foreach ($postItems as $postItem) {
            $post = $this->transformDataToPost($postItem);

            $collection->add($post);
        }

        return $collection;
    }

    /**
     * Transform array with post-data to Post object.
     *
     * @param array<mixed> $post Post data
     *
     * @return Post
     */
    private function transformDataToPost(array $post): Post
    {
        if (empty($post)) {
            return new Post;
        }

        $post = new Post(
            id: (int) $post['id'],
            title: $post['title'],
            slug: $post['slug'],
            intro: $post['intro'],
            content: $post['content'],
            onMainpage: (bool) $post['on_mainpage'],
            publishedAt: $this->parseDate($post['published_at']),
            isPublished: (bool) $post['is_published'],
            createdAt: $this->parseDate($post['created_at']),
            updatedAt: $this->parseDate($post['updated_at'])
        );

        return $post;
    }

    /**
     * Parse date.
     *
     * @param null|string $date Date
     *
     * @throw
     *
     * @return null|DateTimeImmutable
     */
    private function parseDate(?string $date): ?DateTimeImmutable
    {
        if ($date === null || $date === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($date);
        } catch (Throwable $t) {
            $this->logger->warning(
                'Invalid date in PostFinder',
                ['value' => $date, 'exception' => $t]
            );

            return null;
        }
    }
}
