<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\OurOrgan;

use App\Action\Frontend\OurOrgan\OurOrganAction;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(OurOrganAction::class)]
#[UsesClass(TemplateRenderer::class)]
class OurOrganActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'frontend/organ/unsere-orgel',
                []
            )->willReturn(new Response());

        $action = new OurOrganAction($renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
