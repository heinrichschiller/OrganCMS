<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Post;
use App\Domain\Post\PostCollection;
use App\Domain\Post\Repository\PostFinderRepository;
use App\Factory\LoggerFactory;
use Error;
use Exception;
use Psr\Log\LoggerInterface;

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
        $this->logger = $loggerFactory->addFileHandler('error.log')->createLogger();
        $this->repository = $repository;
    }

    /**
     * Find a post by id.
     *
     * @param int $id Post id.
     *
     * @return Post|null
     */
    public function findById(int $id): Post|null
    {
        try {
            $postItem = (array) $this->repository->findById($id);

            if (!empty($postItem)) {
                $post = new Post(
                    $postItem['id'],
                    $postItem['title'],
                    $postItem['slug'],
                    $postItem['content'],
                    $postItem['author'],
                    (bool) $postItem['on_mainpage'],
                    $postItem['published_at'],
                    (bool) $postItem['is_published'],
                    $postItem['created_at'],
                    (string) $postItem['updated_at']
                );

                return $post;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findById(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("PostFinder->findById(): %s", $e->getMessage()));

            return null;
        }
    }

    /**
     * Find all posts.
     *
     * @return PostCollection|null
     */
    public function findAll(): PostCollection|null
    {
        try {
            $postList = (array) $this->repository->findAll();

            if (!empty($postList)) {
                $collection = new PostCollection;
                foreach ($postList as $postItem) {
                    $post = new Post(
                        $postItem['id'],
                        $postItem['title'],
                        $postItem['slug'],
                        $postItem['content'],
                        $postItem['author'],
                        (bool) $postItem['on_mainpage'],
                        $postItem['published_at'],
                        (bool) $postItem['is_published'],
                        $postItem['created_at'],
                        $postItem['updated_at']
                    );
        
                    $collection->add($post);
                }

                return $collection;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findAllPublicPosts(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("PostFinder->findAllPublicPosts(): %s", $e->getMessage()));
            
            return null;
        }
    }

    /**
     * Find all public posts.
     *
     * @return PostCollection|null
     */
    public function findAllPublicPosts(): PostCollection|null
    {
        try {
            $postList = (array) $this->repository->findAllPublicPosts();

            if (!empty($postList)) {
                $collection = new PostCollection;
                foreach ($postList as $postItem) {
                    $post = new Post(
                        (int) $postItem['id'],
                        $postItem['title'],
                        $postItem['slug'],
                        $postItem['content'],
                        $postItem['author'],
                        (bool) $postItem['on_mainpage'],
                        $postItem['published_at'],
                        (bool) $postItem['is_published'],
                        $postItem['created_at'],
                        $postItem['updated_at']
                    );

                    $collection->add($post);
                }

                return $collection;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findAllPublicPosts(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));
            
            return false;
        }
    }
    
    /**
     * Find post for the mainpage.
     *
     * @return Post|null
     */
    public function findMainpagePost(): Post|null
    {
        try {
            $mainpagePost = (array) $this->repository->findMainpagePost();

            if (!empty($mainpagePost)) {
                $post = new Post(
                    $mainpagePost['id'],
                    $mainpagePost['title'],
                    $mainpagePost['slug'],
                    $mainpagePost['content'],
                    $mainpagePost['author'],
                    (bool) $mainpagePost['on_mainpage'],
                    $mainpagePost['published_at'],
                    (bool) $mainpagePost['is_published'],
                    $mainpagePost['created_at'],
                    $mainpagePost['updated_at']
                );
    
                return $post;
            }
            
            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findMainpagePost(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));
            
            return false;
        }
    }

    public function findAllMainpagePosts(int $limit): PostCollection
    {
        try {
            $postList = (array) $this->repository->findAllMainpagePosts($limit);

            if (!empty($postList)) {
                $collection = new PostCollection;
                foreach ($postList as $postItem) {
                    $post = new Post(
                        (int) $postItem['id'],
                        $postItem['title'],
                        $postItem['slug'],
                        $postItem['content'],
                        $postItem['author'],
                        (bool) $postItem['on_mainpage'],
                        $postItem['published_at'],
                        (bool) $postItem['is_published'],
                        $postItem['created_at'],
                        $postItem['updated_at']
                    );

                    $collection->add($post);
                }

                return $collection;
            }

            return null;
        } catch (Exception $e) {
            $this->logger->error(sprintf("PostFinder->findAllPublicPosts(): %s", $e->getMessage()));

            return null;
        } catch (Error $e) {
            $this->logger->error(sprintf("SupportFinder->delete(): %s", $e->getMessage()));
            
            return false;
        }
    }
}
