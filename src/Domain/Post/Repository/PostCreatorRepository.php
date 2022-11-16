<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use App\Domain\Post\Post;
use PDO;

final class PostCreatorRepository
{
    private int $lastInsertId = 0;
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Post $post): void
    {
        $sql = <<<SQL
            INSERT INTO posts(
                title, slug, content, author, on_mainpage, 
                published_at, is_published, created_at, 
                updated_at
            ) 
            VALUES 
            (
                :title, :slug, :content, :author, :on_mainpage, 
                :published_at, :is_published, :created_at, 
                :updated_at
            )
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':title', $post->getTitle());
        $stmt->bindParam(':slug', $post->getSlug());
        $stmt->bindParam(':content', $post->getContent());
        $stmt->bindParam(':author', $post->getAuthor());
        $stmt->bindParam(':on_mainpage', $post->onMainpage());
        $stmt->bindParam(':published_at', $post->getPublishedAt());
        $stmt->bindParam(':is_published', $post->isPublished());
        $stmt->bindParam(':created_at', $post->getCreatedAt());
        $stmt->bindParam(':updated_at', $post->getUpdatedAt());

        $stmt->execute();

        $this->lastInsertId = (int) $this->pdo->lastInsertId();
    }
}
