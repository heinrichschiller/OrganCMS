<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\Post;

use App\Action\Frontend\Post\ReadAction;
use App\Domain\Post\Data\PostReaderResult;
use App\Domain\Post\Service\PostFinder;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(ReadAction::class)]
#[UsesClass(PostFinder::class)]
#[UsesClass(PostReaderResult::class)]
class ReadActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $id = 1;
        $post = new PostReaderResult();

        $finder = $this->createMock(PostFinder::class);
        $finder->expects($this->once())
            ->method('findByIdOrFail')
            ->with($id)
            ->willReturn($post);

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'frontend/post/single-post',
                ['post' => $post]
            )->willReturn(new Response());

        $action = new ReadAction($finder, $renderer);

        $request = (new ServerRequest('GET', '/blog/{id}/{slug}.html'))->withAttribute('id', $id);
        
        $response = $action($request, new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
