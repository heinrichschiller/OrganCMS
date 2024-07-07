<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use App\Domain\Post\Data\Post;
use Doctrine\DBAL\Connection;

final class PostCreatorRepository
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
    public function create(Post $post): void
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
}
