<?php

// declare(strict_types=1);

// namespace Tests\Action\Pages;

// use DI\ContainerBuilder;
// use Selective\TestTrait\Traits\HttpTestTrait;
// use PHPUnit\Framework\TestCase;
// use Slim\App;

// class IndexActionTest extends TestCase
// {
//     use HttpTestTrait;

//     public function testIndexAction(): void
//     {
//         $builder = new ContainerBuilder();
//         (require __DIR__ . '/../../../app/containers.php')($builder);
                
//         $container = $builder->build();
//         $app = $container->get(App::class);

//         $request = $this->createRequest('GET', '/');
//         $response = $app->handle($request);
        
//         $this->assertSame(200, $response->getStatusCode());
//     }
// }
