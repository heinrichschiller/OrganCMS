<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\Event;

use App\Action\Frontend\Event\PublicEventAction;
use App\Domain\Event\Data\EventCollection;
use App\Domain\Event\Service\EventFinder;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Traits\AppTestTrait;

#[CoversClass(PublicEventAction::class)]
#[UsesClass(EventFinder::class)]
#[UsesClass(TemplateRenderer::class)]
class PublicEventActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $events = new EventCollection();

        $reader = $this->createMock(EventFinder::class);
        $reader->expects($this->once())
            ->method('findPublishedEvents')
            ->willReturn($events);

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'event/public-events.html',
                ['events' => $events]
            )->willReturn(new Response());

        $action = new PublicEventAction($reader, $renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
