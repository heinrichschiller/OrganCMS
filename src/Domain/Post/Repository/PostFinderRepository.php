<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use App\Domain\Post\Post;
use App\Domain\Post\PostsCollection;
use PDO;

final class PostFinderRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function whereId(int $id): Post
    {
        $sql = <<<SQL
            SELECT id
                , title
                , slug
                , content
                , author
                , on_mainpage
                , published_at
                , is_published
                , created_at
                , updated_at
                FROM posts
                WHERE id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $post = null;
        if (false !== $row) {
            $post = new Post(
                $row['id'],
                $row['title'],
                $row['slug'],
                $row['content'],
                $row['author'],
                (bool) $row['on_mainpage'],
                $row['published_at'],
                (bool) $row['is_published'],
                $row['created_at'],
                (string) $row['updated_at']
            );
        }
        
        return $post;
    }

    public function findAll(): PostsCollection
    {
        $sql = <<<SQL
            SELECT id
                , title
                , slug
                , content
                , author
                , on_mainpage
                , published_at
                , is_published
                , created_at
                , updated_at
                FROM posts

        SQL;

        $stmt = $this->pdo->query($sql);
        
        $collection = new PostsCollection;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post = new Post(
                $row['id'],
                $row['title'],
                $row['slug'],
                $row['content'],
                $row['author'],
                (bool) $row['on_mainpage'],
                $row['published_at'],
                (bool) $row['is_published'],
                $row['created_at'],
                $row['updated_at']
            );

            $collection->add($post);
        }

        return $collection;
    }

    public function findAllPublicPosts(): PostsCollection
    {
        $sql = <<<SQL
            SELECT id
                , title
                , slug
                , content
                , author
                , on_mainpage
                , published_at
                , is_published
                , created_at
                , updated_at
                FROM posts
                WHERE is_published = 'on'
                ORDER BY published_at DESC
        SQL;

        $stmt = $this->pdo->query($sql);
        
        $collection = new PostsCollection;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post = new Post(
                $row['id'],
                $row['title'],
                $row['slug'],
                $row['content'],
                $row['author'],
                (bool) $row['on_mainpage'],
                $row['published_at'],
                (bool) $row['is_published'],
                $row['created_at'],
                $row['updated_at']
            );

            $collection->add($post);
        }

        return $collection;
    }

    public function findMainpagePost(): Post|null
    {
        $sql = <<<SQL
            SELECT id
                , title
                , slug
                , content
                , author
                , on_mainpage
                , published_at
                , is_published
                , created_at
                , updated_at
                FROM posts
                WHERE on_mainpage = 'on'
                    AND is_published = 'on'
        SQL;

        $stmt = $this->pdo->query($sql);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $post = null;
        if (false !== $row) {
            $post = new Post(
                $row['id'],
                $row['title'],
                $row['slug'],
                $row['content'],
                $row['author'],
                (bool) $row['on_mainpage'],
                $row['published_at'],
                (bool) $row['is_published'],
                $row['created_at'],
                $row['updated_at']
            );
        }

        return $post;
    }
}
