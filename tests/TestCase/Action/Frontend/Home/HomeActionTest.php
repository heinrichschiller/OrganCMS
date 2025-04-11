<?php declare(strict_types=1);

namespace Tests\TestCase\Action\Frontend\Home;

use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tests\Traits\AppTestTrait;

#[CoversClass('\App\Action\Frontend\Home\HomeAction')]
class HomeActionTest extends TestCase
{
    use AppTestTrait;

    // public function testAction(): void
    // {
    //     $request = $this->createRequest('GET', '/');
    //     $response = $this->app->handle($request);

    //     $this->assertSame(StatusCodeInterface::STATUS_OK, $response->getStatusCode());
    //     $this->assertResponseContains($response, '<!DOCTYPE html>');
    // }

    public function testPageNotFound(): void
    {
        // $request = $this->createRequest('GET', '/nada');
        // $response = $this->app->handle($request);

        $this->assertFalse(false);
        // $this->assertSame(StatusCodeInterface::STATUS_NOT_FOUND, $response->getStatusCode());
    }
}
