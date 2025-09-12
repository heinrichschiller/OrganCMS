<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\Imprint;

use App\Action\Frontend\Imprint\ImprintAction;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Traits\AppTestTrait;

#[CoversClass(ImprintAction::class)]
#[UsesClass(TemplateRenderer::class)]
class ImprintActionTest extends TestCase
{
    public function testImprintRendersTemplateAndReturnsOk(): void
    {
        $data = [];

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'frontend/imprint/imprint.html',
                $data
            )->willReturn(new Response());
        
        $action = new ImprintAction($renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
