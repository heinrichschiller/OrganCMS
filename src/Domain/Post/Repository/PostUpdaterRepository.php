<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use App\Domain\Post\Data\Post;
use Doctrine\DBAL\Connection;

final class PostUpdaterRepository
{
    /**
     * @Injection
     * @var Connection
     */
    private Connection $connection;

    /**
     * The contructor.
     *
     * @param Connection $connection Doctrine DBAL connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
}
