<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use Doctrine\DBAL\Connection;

final class PostFinderRepository
{
    /**
     * @Injection
     * @var Connection;
     */
    private Connection $connection;

    /**
     * The constructor.
     *
     * @param Connection $connection Doctrine DBAL connection.
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Find a post by id.
     *
     * @param int $id Post id.
     *
     * @return array
     */
    public function findByIdOrFail(int $id): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'p.id',
                'title',
                'slug',
                'intro',
                'content',
                'author_name',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts', 'p')
            ->leftJoin('p', 'authors', 'a')
            ->where('p.id = ?')
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
    public function findAllOrFail(): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'p.id',
                'title',
                'slug',
                'intro',
                'content',
                'author_name',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts', 'p')
            ->leftJoin('p', 'authors', 'a')
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
                'p.id',
                'title',
                'slug',
                'intro',
                'content',
                'author_name',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts', 'p')
            ->leftJoin('p', 'authors', 'a')
            ->where("is_published = '1'")
            ->orderBy('published_at', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative() ?: [];

        return $result;
    }

    /**
     * Find all public posts
     *
     * @param int $limit
     *
     * @return array
     */
    public function findAllMainpagePosts(int $limit): array
    {
        $result = $this->connection
            ->createQueryBuilder()
            ->select(
                'p.id',
                'title',
                'slug',
                'intro',
                'content',
                'author_name',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts', 'p')
            ->leftJoin('p', 'authors', 'a')
            ->where("is_published = '1'")
            ->orderBy('published_at', 'DESC')
            ->setMaxResults($limit)
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
                'p.id',
                'title',
                'slug',
                'intro',
                'content',
                'author_name',
                'on_mainpage',
                'published_at',
                'is_published',
                'created_at',
                'updated_at'
            )
            ->from('posts', 'p')
            ->leftJoin('p', 'authors', 'a')
            ->where("on_mainpage = 'on'")
            ->andWhere("is_published = 'on'")
            ->executeQuery()
            ->fetchAssociative() ?: [];

        return $result;
    }
}
