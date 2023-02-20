<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use Doctrine\DBAL\Connection;

final class PostFinderRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findById(int $id): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'author',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts')
            ->where('id = ?')
            ->setParameter(0, $id)
            ->executeQuery()
            ->fetchAssociative() ?: [];

        return $result;
    }

    /**
     * Find all posts.
     *
     * @return array
     */
    public function findAll(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'author',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];
        

        return $result;
    }

    /**
     * Find all public posts
     *
     * @return array
     */
    public function findAllPublicPosts(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'author',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts')
            ->where("is_published = 'on'")
            ->orderBy('published_at', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];

        return $result;
    }

    /**
     * Find a post that is showing on mainpage
     *
     * @return array
     */
    public function findMainpagePost(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'content',
                'author',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts')
            ->where("on_mainpage = 'on'")
            ->andWhere("is_published = 'on'")
            ->executeQuery()
            ->fetchAssociative() ?: [];

        return $result;
    }
}
