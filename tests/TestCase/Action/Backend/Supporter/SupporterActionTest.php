<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Backend\Supporter;

use App\Action\Backend\Supporter\SupporterAction;
use App\Domain\Supporter\Data\SupporterCollection;
use App\Domain\Supporter\Service\SupporterFinder;
use App\Renderer\TemplateRenderer;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use Odan\Session\PhpSession;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

#[CoversClass(SupporterAction::class)]
#[UsesClass(SupporterFinder::class)]
#[UsesClass(TemplateRenderer::class)]
class SupporterActionTest extends TestCase
{
    public function testInvokeRendersTemplateAndReturnsOk(): void
    {
        $isSuccess = false;
        $isError = false;
        $message = '';


        $collection = new SupporterCollection();
        $session = new PhpSession();

        $finder = $this->createMock(SupporterFinder::class);
        $finder->expects($this->once())
            ->method('findAll')
            ->willReturn($collection);
        
        $data = [
            'supporters' => $collection,
            'isSuccess' => $isSuccess,
            'isError' => $isError,
            'message' => $message
        ];

        $renderer = $this->createMock(TemplateRenderer::class);
        $renderer->expects($this->once())
            ->method('render')
            ->with(
                $this->isInstanceOf(ResponseInterface::class),
                'backend/supporter/index',
                $data
            )->willReturn(new Response());

        $action = new SupporterAction($session, $finder, $renderer);

        $response = $action(new Response());

        $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    }
}
