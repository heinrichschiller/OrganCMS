<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Backend\Dashboard;

use App\Action\Backend\Dashboard\DashboardAction;
use App\Domain\Dashboard\Service\DashboardReader;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(DashboardAction::class)]
#[UsesClass(DashboardReader::class)]
#[UsesClass(TemplateRenderer::class)]
class DashboardTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $reader = $this->createMock(DashboardReader::class);
        $reader->expects($this->once())
            ->method('read')
            ->willReturn([]);

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'backend/dashboard/dashboard',
                []
            )->willReturn(new Response());

        $action = new DashboardAction($reader, $renderer);

        $response = $action(new Response());
        
        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
