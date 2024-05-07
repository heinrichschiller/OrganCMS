<?php

declare(strict_types=1);

namespace Tests\Renderer;

use App\Renderer\TemplateRenderer;
use Selective\Config\Configuration;
use Mustache_Engine;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

#[CoversClass(TemplateRenderer::class)]
class TemplateRendererTest extends TestCase
{
    private Configuration $config;
    private Mustache_Engine $engine;

    public function setUp(): void
    {
        $this->config = new Configuration([]);
        $this->engine = new Mustache_Engine();
    }

    public function testRender(): void
    {
        $renderer = new TemplateRenderer($this->config, $this->engine);

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
