<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\Dsgvo;

use App\Action\Frontend\Dsgvo\DsgvoAction;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Traits\AppTestTrait;

#[CoversClass(DsgvoAction::class)]
#[UsesClass(TemplateRenderer::class)]
class DsgvoActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $data = [];

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'frontend/dsgvo/datenschutzerklaerung.html',
                $data
            )->willReturn(new Response());
        
        $action = new DsgvoAction($renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
