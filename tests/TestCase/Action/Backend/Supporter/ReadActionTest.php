<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Backend\Supporter;

use App\Action\Backend\Supporter\ReadAction;
use App\Domain\Supporter\Data\Supporter;
use App\Domain\Supporter\Service\SupporterFinder;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(ReadAction::class)]
#[UsesClass(Supporter::class)]
#[UsesClass(SupporterFinder::class)]
#[UsesClass(TemplateRenderer::class)]
class ReadActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $id = 1;

        $supporter = new Supporter();

        $finder = $this->createMock(SupporterFinder::class);
        $finder->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($supporter);
        
        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'backend/supporter/edit',
                ['supporter' => $supporter]
            )->willReturn(new Response());
        
        $action = new ReadAction($finder, $renderer);

        $request = (new ServerRequest('GET', '/edit/{id}'))
            ->withAttribute('id', $id);

        $response = $action($request, new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
