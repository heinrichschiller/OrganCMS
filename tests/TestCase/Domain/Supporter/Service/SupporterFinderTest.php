<?php

declare(strict_types=1);

namespace Tests\TestCase\Domain\Supporter\Service;

use App\Domain\Supporter\Data\Supporter;
use App\Domain\Supporter\Data\SupporterCollection;
use App\Domain\Supporter\Repository\SupporterFinderRepository;
use App\Domain\Supporter\Service\SupporterFinder;
use App\Factory\LoggerFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

#[CoversClass(SupporterFinder::class)]
#[UsesClass(Supporter::class)]
#[UsesClass(SupporterCollection::class)]
final class SupporterFinderTest extends TestCase
{
    private function makeLoggerFactoryMock(LoggerInterface $logger): LoggerFactory
    {
        $loggerFactory = $this->createMock(LoggerFactory::class);

        $loggerFactory
            ->method('addFileHandler')
            ->with('supporter-finder-error.log')
            ->willReturn($loggerFactory);
        
        $loggerFactory
            ->method('createLogger')
            ->willReturn($logger);

        return $loggerFactory;
    }

    private function sampleSupporter(array $override = []): array
    {
        $post = [
            'id' => 1,
            'name' => '  post test  ',
            'is_published' => 0,
            'published_at' => '2025-01-01 20:00:00',
            'created_at' => '2025-01-01 20:00:00',
            'updated_at' => '2025-01-01 20:00:00'
        ];

        return array_replace($post, $override);
    }

    #[Test]
    public function findAllSupporters(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(SupporterFinderRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn([
                $this->sampleSupporter(['id' => 1, 'name' => 'Heinrich']),
                $this->sampleSupporter(['id' => 1, 'name' => 'Ella']),
                $this->sampleSupporter(['id' => 1, 'name' => 'Rudolf']),
            ]);

        $finder = new SupporterFinder($loggerFactory, $repository);

        $supporterCollection = $finder->findAll();

        $this->assertCount(3, $supporterCollection);
        $this->assertInstanceOf(SupporterCollection::class, $supporterCollection);
    }

    #[Test]
    public function findAllPublicSupporter(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(SupporterFinderRepository::class);
        $repository->expects($this->once())
            ->method('findAllPublicSupporter')
            ->willReturn([
                $this->sampleSupporter(['id' => 1, 'name' => 'Heinrich']),
                $this->sampleSupporter(['id' => 1, 'name' => 'Ella']),
                $this->sampleSupporter(['id' => 1, 'name' => 'Rudolf']),
            ]);

        $finder = new SupporterFinder($loggerFactory, $repository);

        $supporterCollection = $finder->findAllPublicSupporter();

        $this->assertCount(3, $supporterCollection);
        $this->assertInstanceOf(SupporterCollection::class, $supporterCollection);
    }

    #[Test]
    public function findASupporterById(): void
    {
        $logger = $this->createMock(LoggerInterface::class);
        $loggerFactory = $this->makeLoggerFactoryMock($logger);

        $repository = $this->createMock(SupporterFinderRepository::class);
        $repository->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn(
                $this->sampleSupporter(['id' => 1, 'name' => 'Heinrich'])
            );
        
        $finder = new SupporterFinder($loggerFactory, $repository);

        $supporter = $finder->findById(1);

        $this->assertInstanceOf(Supporter::class, $supporter);
        $this->assertSame('Heinrich', $supporter->getName());
    }
}
