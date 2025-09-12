<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\OrganAct;

use App\Action\Frontend\OrganAct\OrganActAction;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(OrganActAction::class)]
#[UsesClass(TemplateRenderer::class)]
class OrganActActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $data = [];

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'frontend/organact/organ-act',
                $data
            )->willReturn(new Response());
        
        $action = new OrganActAction($renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
