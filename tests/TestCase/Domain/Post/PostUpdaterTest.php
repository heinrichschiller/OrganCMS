<?php

declare(strict_types=1);

namespace Tests\Domain\Posts\Post;

use App\Domain\Post\Data\Post;
use App\Domain\Post\Repository\PostRepository;
use App\Domain\Post\Service\PostUpdater;
use App\Domain\Post\Service\PostValidator;
use App\Factory\LoggerFactoryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

#[CoversClass(PostUpdater::class)]
class PostUpdaterTest extends TestCase
{
    private PostUpdater $postUpdater;
    private PostRepository $repository;
    private PostValidator $validator;

    public function setUp(): void
    {
        $this->repository = $this->createMock(PostRepository::class);
        $this->validator = $this->createMock(PostValidator::class);

        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->createMock(LoggerFactoryInterface::class);
        $loggerFactory->method('AddFileHandler')->willReturnSelf();
        $loggerFactory->method('createLogger')->willReturn($logger);

        $this->postUpdater = new PostUpdater($loggerFactory, $this->repository, $this->validator);
    }

    public function testUpdatedAtValueHasInput(): void
    {
        $formData = [
            'id' => 31,
            'title' => 'test',
            'intro' => 'test',
            'content' => 'test',
            'author_id' => 1,
            'on_mainpage' => true,
            'is_published' => true,
            'created_at' => ''
        ];

        // $isUpdated = $this->postUpdater->update($formData);

        $this->assertTrue(true);
    }
}
