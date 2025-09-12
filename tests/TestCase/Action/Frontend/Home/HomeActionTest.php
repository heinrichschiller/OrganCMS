<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\Home;

use App\Action\Frontend\Home\HomeAction;
use App\Domain\Home\Service\HomeReader;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Traits\AppTestTrait;

#[CoversClass(HomeAction::class)]
#[UsesClass(HomeReader::class)]
#[UsesClass(TemplateRenderer::class)]
class HomeActionTest extends TestCase
{
    use AppTestTrait;

    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $data = [];

        $reader = $this->createMock(HomeReader::class);
        $reader->expects($this->once())
            ->method('read')
            ->willReturn($data);

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'frontend/home/index',
                $data
            )->willReturn(new Response());

        $action = new HomeAction($reader, $renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
