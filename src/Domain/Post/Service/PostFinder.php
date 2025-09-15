<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Data\PostReaderResult;
use App\Domain\Post\Data\PostReaderResultCollection;
use App\Domain\Post\Repository\PostFinderRepository;
use App\Factory\LoggerFactory;
use DateTimeImmutable;
use Error;
use Exception;
use Psr\Log\LoggerInterface;
use Selective\ArrayReader\ArrayReader;

use function sprintf;

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
    public function __construct(LoggerFactory $loggerFactory, PostFinderRepository $repository)
    {
        $this->logger = $loggerFactory->addFileHandler('post-finder-error.log')->createLogger();
        $this->repository = $repository;
    }

    /**
     * Find a post by id.
     *
     * @param int $id Post id.
     *
     * @return PostReaderResult
     */
    public function findByIdOrFail(int $id): PostReaderResult
    {
        try {
            $postItem = (array) $this->repository->findByIdOrFail($id);

            if (!empty($postItem)) {
                $result = $this->getPostReaderResult($postItem);

                return $result;
            }

            return new PostReaderResult;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findByIdOrFail(): %s", $e->getMessage()));

            return new PostReaderResult;
        } catch (Error $e) {
            $this->logger->error(sprintf("PostFinder->findByIdOrFail(): %s", $e->getMessage()));

            return new PostReaderResult;
        }
    }

    /**
     * Find all posts or fail.
     *
     * @return PostCollection
     */
    public function findAllOrFail(): PostReaderResultCollection
    {
        $collection = new PostReaderResultCollection;

        try {
            $postList = (array) $this->repository->findAllOrFail();

            if (!empty($postList)) {
                foreach ($postList as $postItem) {
                    $result = $this->getPostReaderResult($postItem);
        
                    $collection->add($result);
                }
            }

            return $collection;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findAllOrFail(): %s", $e->getMessage()));

            return $collection;
        } catch (Error $e) {
            $this->logger->error(sprintf("PostFinder->findAllOrFail(): %s", $e->getMessage()));
            
            return $collection;
        }
    }

    /**
     * Find all public posts.
     *
     * @return PostCollection
     */
    public function findAllPublicPosts(): PostReaderResultCollection
    {
        $collection = new PostReaderResultCollection;

        try {
            $postItems = $this->repository->findAllPublicPosts();
            dd($postItems);
            if (!empty($postList)) {
                foreach ($postList as $item) {
                    $result = $this->getPostReaderResult($postItem);

                    $collection->add($result);
                }
            }

            return $collection;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findAllPublicPosts(): %s", $e->getMessage()));

            return $collection;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));
            
            return $collection;
        }
    }
    
    /**
     * Find post for the mainpage.
     *
     * @return PostReaderResult.
     */
    public function findMainpagePost(): PostReaderResult
    {
        try {
            $postItem = (array) $this->repository->findMainpagePost();

            if (!empty($mainpagePost)) {
                $result = $this->getPostReaderResult($postItem);
    
                return $result;
            }
            
            return new PostReaderResult;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findMainpagePost(): %s", $e->getMessage()));

            return new PostReaderResult;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));
            
            return new PostReaderResult;
        }
    }

    public function findAllMainpagePosts(int $limit): PostReaderResultCollection
    {
        $collection = new PostReaderResultCollection;

        // try {
            $postItem = (array) $this->repository->findAllMainpagePosts($limit);

        if (!empty($postList)) {
            foreach ($postList as $postItem) {
                $result = $this->getPostReaderResult($postItem);

                $collection->add($result);
            }
        }

            return $collection;
        // } catch (Exception $e) {
        //     $this->logger->error(sprintf("PostFinder->findAllPublicPosts(): %s", $e->getMessage()));

        //     return $collection;
        // } catch (Error $e) {
        //     $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));
            
        //     return $collection;
        // }
    }

    private function getPostReaderResult(array $postItem): PostReaderResult
    {
        $publishedAt = new DateTimeImmutable($postItem['published_at']);
        $createdAt = new DateTimeImmutable($postItem['created_at']);
        $updatedAt = new DateTimeImmutable($postItem['updated_at']);

        $post = new PostReaderResult(
            id: (int) $postItem['id'],
            title: $postItem['title'],
            slug: $postItem['slug'],
            intro: $postItem['intro'],
            content: $postItem['content'],
            onMainpage: (bool) $postItem['on_mainpage'],
            publishedAt: $publishedAt,
            isPublished: (bool) $postItem['is_published'],
            createdAt: $createdAt,
            updatedAt: $updatedAt
        );

        return $post;
    }
}
