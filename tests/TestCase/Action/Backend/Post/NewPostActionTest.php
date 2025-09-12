<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Backend\Post;

use App\Action\Backend\Post\NewPostAction;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(NewPostAction::class)]
#[UsesClass(TemplateRenderer::class)]
final class NewPostActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $data = [];

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'backend/post/create',
                $data
            )->willReturn(new Response());

        $action = new NewPostAction($renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
