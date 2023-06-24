<?php

declare(strict_types=1);

namespace Tests\Renderer;

use App\Renderer\TemplateRenderer;
use Mustache_Engine;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class TemplateRendererTest extends TestCase
{
    private Mustache_Engine $engine;

    public function setUp(): void
    {
        $this->engine = new Mustache_Engine();
    }

    /**
     * @covers App\Renderer\TemplateRenderer
     */
    public function testRender(): void
    {
        $renderer = new TemplateRenderer($this->engine);

        $data = [
            'title' => 'Hello, World!',
            'body' => 'This is a test.',
        ];

        $responseBody = $this->createMock(StreamInterface::class);
        $responseBody->expects($this->once())
            ->method('write')
            ->with($this->engine->render('test', $data));

        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())
            ->method('getBody')
            ->willReturn($responseBody);
        
        $result = $renderer->render($response, 'test', $data);

        $this->assertInstanceOf(ResponseInterface::class, $result);
    }
}
