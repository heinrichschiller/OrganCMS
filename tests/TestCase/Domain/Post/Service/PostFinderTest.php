<?php

declare(strict_types=1);

namespace Tests\TestCase\Domain\Post\Service;

use App\Domain\Post\Data\Post;
use App\Domain\Post\Data\PostCollection;
use App\Domain\Post\Repository\PostFinderRepository;
use App\Domain\Post\Service\PostFinder;
use App\Factory\LoggerFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

#[CoversClass(PostFinder::class)]
#[UsesClass(Post::class)]
#[UsesClass(PostCollection::class)]
final class PostFinderTest extends TestCase
{
    private function makeLoggerFactoryMock(LoggerInterface $logger): LoggerFactory
    {
        $loggerFactory = $this->createMock(LoggerFactory::class);

        $loggerFactory
            ->method('addFileHandler')
            ->with('post-finder-error.log')
            ->willReturn($loggerFactory);
        
        $loggerFactory
            ->method('createLogger')
            ->willReturn($logger);

        return $loggerFactory;
    }

    private function samplePost(array $override = []): array
    {
        $post = [
            'id' => 1,
            'title' => '  post test  ',
            'slug' => 'post-test/test/post',
            'intro' => 'Intro',
            'content' => 'Full test content',
            'on_mainpage' => 1,
            'published_at' => '2025-01-01 20:00:00',
            'is_published' => 0,
            'created_at' => '2025-01-01 20:00:00',
            'updated_at' => '2025-01-01 20:00:00'
        ];

        return array_replace($post, $override);
    }

    #[Test]
    public function findAPostById(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(PostFinderRepository::class);
        $repository->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn(
                $this->samplePost([
                    'id' => 1,
                    'created_at' => '2025-01-01 20:00:00'
                ])
            );
        
        $finder = new PostFinder($loggerFactory, $repository);
        
        $post = $finder->findById(1);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertSame(1, $post->getId());
    }

    #[Test]
    public function findAllPosts(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(PostFinderRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn([
                $this->samplePost(['id' => 1, 'title' => 'Sample post 1']),
                $this->samplePost(['id' => 2, 'title' => 'Sample post 2']),
                $this->samplePost(['id' => 3, 'title' => 'Sample post 3']),
            ]);
        
        $finder = new PostFinder($loggerFactory, $repository);

        $postCollection = $finder->findAll();

        $this->assertInstanceOf(PostCollection::class, $postCollection);
        $this->assertCount(3, $postCollection);
    }

    #[Test]
    public function findAllPublicPosts(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(PostFinderRepository::class);
        $repository->expects($this->once())
            ->method('findAllPublicPosts')
            ->willReturn([
                $this->samplePost(['id' => 1, 'title' => 'Sample post 1']),
                $this->samplePost(['id' => 2, 'title' => 'Sample post 2']),
                $this->samplePost(['id' => 3, 'title' => 'Sample post 3']),
            ]);
        
        $finder = new PostFinder($loggerFactory, $repository);

        $postCollection = $finder->findAllPublicPosts();

        $this->assertInstanceOf(PostCollection::class, $postCollection);
        $this->assertCount(3, $postCollection);
    }

    #[Test]
    public function findMainPagePost(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(PostFinderRepository::class);
        $repository->expects($this->once())
            ->method('findMainpagePost')
            ->willReturn(
                $this->samplePost(['id' => 1, 'title' => 'Sample post 1']),
            );
        
        $finder = new PostFinder($loggerFactory, $repository);

        $post = $finder->findMainPagePost();

        $this->assertInstanceOf(Post::class, $post);
        $this->assertSame(1, $post->getId());
    }

    #[Test]
    public function findMainPagePosts(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $limit = 3;
        $repository = $this->createMock(PostFinderRepository::class);
        $repository->expects($this->once())
            ->method('findAllMainpagePosts')
            ->with($limit)
            ->willReturn([
                $this->samplePost(['id' => 1, 'title' => 'Sample post 1']),
                $this->samplePost(['id' => 2, 'title' => 'Sample post 2']),
                $this->samplePost(['id' => 3, 'title' => 'Sample post 3']),
            ]);

        $finder = new PostFinder($loggerFactory, $repository);

        $postCollection = $finder->findAllMainpagePosts($limit);

        $this->assertInstanceOf(PostCollection::class, $postCollection);
        $this->assertCount(3, $postCollection);
    }
}
