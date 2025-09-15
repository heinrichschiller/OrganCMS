<?php

declare(strict_types=1);

namespace Tests\TestCase\Action\Backend\Supporter;

use App\Action\Backend\Supporter\CreateAction;
use App\Domain\Supporter\Service\SupporterCreator;
use Fig\Http\Message\StatusCodeInterface;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\ServerRequest;
use Odan\Session\FlashInterface;
use Odan\Session\SessionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Slim\Interfaces\RouteParserInterface;
use Slim\Routing\RouteContext;
use Slim\Routing\RoutingResults;

#[CoversClass(CreateAction::class)]
#[UsesClass(SupporterCreator::class)]
final class CreateActionTest extends TestCase
{
    public function testCreateSuccessRedirectsAndSetsSuccessFlash(): void
    {
        $formData = ['name' => 'Heinrich'];

        $creator = $this->createMock(SupporterCreator::class);
        $creator->expects($this->once())
            ->method('insert')
            ->with($formData)
            ->willReturn(true);

        $flash = $this->createMock(FlashInterface::class);
        $flash->expects($this->once())->method('clear');
        $flash->expects($this->once())
            ->method('add')
            ->with('success', 'Eintrag erfolgreich angelegt.');

        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
            ->method('getFlash')
            ->willReturn($flash);

        $routeParser = $this->createMock(RouteParserInterface::class);
        $routeParser->expects($this->once())
            ->method('urlFor')
            ->with('supporter')
            ->willReturn('/backend/supporter');
        
        $routingResults = $this->createMock(RoutingResults::class);

        $request = (new ServerRequest('POST', '/backend/supporter'))
            ->withParsedBody($formData)
            ->withAttribute(RouteContext::ROUTE_PARSER, $routeParser)
            ->withAttribute(RouteContext::ROUTING_RESULTS, $routingResults)
            ->withAttribute(RouteContext::BASE_PATH, '');
        
        $action = new CreateAction($creator, $session);

        $response = $action($request, new Response());

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
        $this->assertSame('/backend/supporter', $response->getHeaderLine('Location'));
    }

    public function testCreateFailureRedirectAndSetsErrorFlash(): void
    {
        $formData = ['name' => 'Heinrich'];

        $creator = $this->createMock(SupporterCreator::class);
        $creator->expects($this->once())
            ->method('insert')
            ->with($formData)
            ->willReturn(false);
        
        $flash = $this->createMock(FlashInterface::class);
        $flash->expects($this->once())->method('clear');
        $flash->expects($this->once())
            ->method('add')
            ->with(
                'error',
                'Es ist ein Fehler aufgetretten. Der Eintrag konnte nicht gespeichert werden.'
            );
        
        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())
            ->method('getFlash')
            ->willReturn($flash);

        $routeParser = $this->createMock(RouteParserInterface::class);
        $routeParser->expects($this->once())
            ->method('urlFor')
            ->with('supporter')
            ->willReturn('/backend/supporter');

        $routingResults = $this->createMock(RoutingResults::class);

        $request = (new ServerRequest('POST', '/backend/supporter'))
            ->withParsedBody($formData)
            ->withAttribute(RouteContext::ROUTE_PARSER, $routeParser)
            ->withAttribute(RouteContext::ROUTING_RESULTS, $routingResults)
            ->withAttribute(RouteContext::BASE_PATH, '');

        $action = new CreateAction($creator, $session);

        $response = $action($request, new Response());

        $this->assertSame(StatusCodeInterface::STATUS_FOUND, $response->getStatusCode());
        $this->assertSame('/backend/supporter', $response->getHeaderLine('Location'));

    }
}