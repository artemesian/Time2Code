<?php
namespace Tests\Framework;

use Framework\Application;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{

    public function setUp(): void
    {

    }

    public function testArrayLength(): void
    {
        $stack = [];
        $this->assertSame(0, count($stack));
    }

    public function testRedirectTrainingslash():void
    {
        $app = new Application();
        $request = new ServerRequest('GET', '/demoSlash/');
        $response = $app->run($request);
        $this->assertContains('/demoSlash', $response->getHeader('Location'));
        $this->assertSame(301, $response->getStatusCode());

    }

    public function testBlog():void
    {
        $app = new Application();
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertStringContainsString("<h1>Bienvenue sur le Blog</h1>", (string)$response->getBody());
        $this->assertSame(200, $response->getStatusCode());
    }

    public function test404():void
    {
        $app = new Application();
        $request = new ServerRequest('GET', '/notFound');
        $response = $app->run($request);

        $this->assertStringContainsString("<h1>Erreur 404</h1>", (string)$response->getBody());
        $this->assertSame(404, $response->getStatusCode());
    }


}

