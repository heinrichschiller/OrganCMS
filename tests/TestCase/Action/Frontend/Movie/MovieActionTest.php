<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\Movie;

use App\Action\Frontend\Movie\MovieAction;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Traits\AppTestTrait;

#[CoversClass(MovieAction::class)]
#[UsesClass(TemplateRenderer::class)]
class MovieActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $renderer = $this->createMock(TemplateRenderer::class);

        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'frontend/movies/movies.html',
                []
            )->willReturn(new Response());

        $action = new MovieAction($renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
