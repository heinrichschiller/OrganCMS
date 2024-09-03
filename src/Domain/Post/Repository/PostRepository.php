<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use App\Domain\Post\Data\Post;
use Doctrine\DBAL\Connection;

class PostRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection Doctrine DBAL connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Create a new post.
     *
     * @param Post $post Post object
     *
     * @return void
     */
    public function createPost(Post $post): void
    {
        $this->connection
            ->createQueryBuilder()
            ->insert('posts')
            ->setValue('title', '?')
            ->setValue('slug', '?')
            ->setValue('intro', '?')
            ->setValue('content', '?')
            ->setValue('author_id', '?')
            ->setValue('on_mainpage', '?')
            ->setValue('published_at', '?')
            ->setValue('is_published', '?')
            ->setValue('created_at', '?')
            ->setValue('updated_at', '?')
            ->setParameter(0, $post->getTitle())
            ->setParameter(1, $post->getSlug())
            ->setParameter(2, $post->getIntro())
            ->setParameter(3, $post->getContent())
            ->setParameter(4, $post->getAuthorId())
            ->setParameter(5, $post->onMainpage())
            ->setParameter(6, $post->getPublishedAt())
            ->setParameter(7, $post->isPublished())
            ->setParameter(8, $post->getCreatedAt())
            ->setParameter(9, $post->getUpdatedAt())
            ->executeQuery();
    }

    /**
     * Update a post.
     *
     * @param Post $post The post data.
     */
    public function update(Post $post): void
    {
        $this->connection
            ->createQueryBuilder()
            ->update('posts')
            ->set('title', ':title')
            ->set('slug', ':slug')
            ->set('intro', ':intro')
            ->set('content', ':content')
            ->set('author_id', ':author_id')
            ->set('on_mainpage', ':on_mainpage')
            ->set('published_at', ':published_at')
            ->set('is_published', ':is_published')
            ->set('created_at', ':created_at')
            ->set('updated_at', ':updated_at')
            ->where('id = :id')
            ->setParameter('title', $post->getTitle())
            ->setParameter('slug', $post->getSlug())
            ->setParameter('intro', $post->getIntro())
            ->setParameter('content', $post->getContent())
            ->setParameter('author_id', $post->getAuthorId())
            ->setParameter('on_mainpage', $post->onMainpage())
            ->setParameter('published_at', $post->getPublishedAt())
            ->setParameter('is_published', $post->isPublished())
            ->setParameter('created_at', $post->getCreatedAt())
            ->setParameter('updated_at', $post->getUpdatedAt())
            ->setParameter('id', $post->getId())
            ->executeQuery();
    }

    /**
     * Delete supporter by id.
     *
     * @param int $id Post id.
     *
     * @return void
     */
    public function deletePost(int $id): void
    {
        $this->connection
            ->createQueryBuilder()
            ->delete('posts')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery();
    }

    /**
     * Exists post id or not.
     * 
     * @param int $postId Post id.
     * 
     * @return bool
     */
    public function existsPostId(int $postId): bool
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select('id')
            ->from('posts')
            ->where('id = ?')
            ->setParameter(0, $postId)
            ->executeQuery();
        
        return (bool) $result;
    }
}
