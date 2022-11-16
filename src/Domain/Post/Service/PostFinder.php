<?php

declare(strict_types=1);

namespace App\Domain\Post\Service;

use App\Domain\Post\Post;
use App\Domain\Post\PostsCollection;
use App\Domain\Post\Repository\PostFinderRepository;

final class PostFinder
{
    private PostFinderRepository $repository;

    public function __construct(PostFinderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function whereId(int $id): Post
    {
        return $this->repository->whereId($id);
    }

    public function findAll(): PostsCollection
    {
        return $this->repository->findAll();
    }

    public function findAllPublicPosts(): PostsCollection
    {
        return $this->repository->findAllPublicPosts();
    }
    
    public function findMainpagePost(): Post|null
    {
        return $this->repository->findMainpagePost();
    }
}
