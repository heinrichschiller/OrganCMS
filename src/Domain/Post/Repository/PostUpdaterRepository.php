<?php

declare(strict_types=1);

namespace App\Domain\Post\Repository;

use App\Domain\Post\Post;
use PDO;

final class PostUpdaterRepository
{
    /**
     * @Injection
     * @var PDO
     */
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Update a post.
     *
     * @param array<string> $formData The form data.
     */
    public function update(array $formData): void
    {
        $sql = <<<SQL
            UPDATE posts
                SET title = :title,
                    slug = :slug,
                    content = :content,
                    author = :author,
                    on_mainpage = :on_mainpage,
                    published_at = :published_at,
                    is_published = :is_published,
                    created_at = :created_at,
                    updated_at = :updated_at
                    WHERE id = :id
        SQL;

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $formData['id']);
        $stmt->bindParam(':title', $formData['title']);
        $stmt->bindParam(':slug', $formData['slug']);
        $stmt->bindParam(':content', $formData['content']);
        $stmt->bindParam(':author', $formData['author']);
        $stmt->bindParam(':on_mainpage', $formData['on_mainpage']);
        $stmt->bindParam(':published_at', $formData['published_at']);
        $stmt->bindParam(':is_published', $formData['is_published']);
        $stmt->bindParam(':created_at', $formData['created_at']);
        $stmt->bindParam(':updated_at', $formData['updated_at']);

        $stmt->execute();
    }
}
