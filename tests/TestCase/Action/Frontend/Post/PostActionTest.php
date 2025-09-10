<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\Post;

use App\Action\Frontend\Post\PostAction;
use App\Domain\Post\Data\PostReaderResultCollection;
use App\Domain\Post\Service\PostFinder;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(PostAction::class)]
#[UsesClass(TemplateRenderer::class)]
class PostActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $postItems = new PostReaderResultCollection();

        $finder = $this->createMock(PostFinder::class);
        $finder->expects($this->once())
            ->method('findAllPublicPosts')
            ->willReturn($postItems);

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'frontend/post/index.html',
                ['post' => $postItems]
            )->willReturn(new Response());
        
        $action = new PostAction($finder, $renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
