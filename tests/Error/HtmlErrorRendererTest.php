<?php

declare(strict_types=1);

namespace Tests\Error;

use App\Error\Renderer\HtmlErrorRenderer;
use PHPUnit\Framework\TestCase;

class HtmlErrorRendererTest extends TestCase
{
    /** @covers App\Error\Renderer\HtmlErrorRenderer */
    public function testHtmlErrorRendererTest()
    {
        $error = new HtmlErrorRenderer;

        $this->assertInstanceOf(HtmlErrorRenderer::class, $error);
    }
}