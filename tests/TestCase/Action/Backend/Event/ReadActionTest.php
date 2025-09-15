<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Backend\Event;

use App\Action\Backend\Event\ReadAction;
use App\Domain\Event\Data\Event;
use App\Domain\Event\Service\EventFinder;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use Odan\Session\PhpSession;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

#[CoversClass(ReadAction::class)]
#[UsesClass(Event::class)]
#[UsesClass(EventFinder::class)]
#[UsesClass(TemplateRenderer::class)]
class ReadActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $id = 1;
        $isSuccess = false;
        $message = '';

        $event = new Event();
        $session = new PhpSession();

        $finder = $this->createMock(EventFinder::class);
        $finder->expects($this->once())
            ->method('findByIdOrFail')
            ->with($id)
            ->willReturn($event);
        
        $data = [
            'event' => $event,
            'isSuccess' => $isSuccess,
            'message' => $message
        ];

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'backend/event/edit',
                $data
            )->willReturn(new Response());

        $action = new ReadAction($finder, $session, $renderer);

        $request = (new ServerRequest('GET', '/read/{id}'))
            ->withAttribute('id', $id);

        $response = $action($request, new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
