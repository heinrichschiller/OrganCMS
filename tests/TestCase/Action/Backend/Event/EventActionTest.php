<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Backend\Action\Event;

use App\Action\Backend\Event\EventAction;
use App\Domain\Event\Data\EventCollection;
use App\Domain\Event\Service\EventFinder;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use Odan\Session\PhpSession;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(EventAction::class)]
#[UsesClass(EventFinder::class)]
#[UsesClass(TemplateRenderer::class)]
class EventActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $isSuccess = false;
        $isError = false;
        $message = '';

        $events = new EventCollection();
        $session = new PhpSession();

        $finder = $this->createMock(EventFinder::class);
        $finder->expects($this->once())
            ->method('findAllOrFail')
            ->willReturn($events);

        $data = [
            'events' => $events,
            'isSuccess' => $isSuccess,
            'isError' => $isError,
            'message' => $message
        ];

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'backend/event/index',
                $data
            )->willReturn(new Response());
        
        $action = new EventAction($finder, $session, $renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
