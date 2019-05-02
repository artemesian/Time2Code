<?php
namespace Tests\Framework\Router;

use Time2Code\Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $request = new ServerRequest('GET', '/blog');
        $this->router->get('/blog', function(){ return "Blog callback"; }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals("Blog callback", call_user_func_array($route->getCallback(), [$request]));
    }

    public function testGetMethodIfUrlNotExist()
    {
        $request = new ServerRequest('Get', "/NotExistUrl");
        $this->router->get('/blog', function(){ return "Blog Route"; }, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals(NULL, $route);
    }

    public function testGetMethodWithParameters()
    {
        $request = new ServerRequest('GET', '/blog/mon-slug-9');
        $this->router->get('/blog/{slug:[a-z\-0-9]+}-{id:[\d]+}',
            function(){ return "Blog Route with slug";}, 'blog.show');
        $route = $this->router->match($request);
        $this->assertEquals('blog.show', $route->getName());
        $this->assertEquals("Blog Route with slug", call_user_func_array($route->getCallback(), [$request]));
        $this->assertSame(['slug' => "mon-slug", 'id' => '9'], $route->getParams());
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog', function(){ return "Bienvenue sur le blog"; }, 'blog');
        $this->router->get('/blog/{slug:[a-z\-0-9]+}-{id:[\d]+}', function(){ return "Article de teste"; }, 'post.show');
        $uri = $this->router->generateURI('post.show', ['slug' => 'article-teste', 'id' => 19]);
        $url = $this->router->generateURI('blog', []);
        $this->assertEquals('/blog', $url);
        $this->assertEquals('/blog/article-teste-19', $uri);
    }

    public function testInvalideUrl()
    {
        $request = new ServerRequest('GET', '/blog/mon_slug-8');
        $route = $this->router->match($request);
        $this->assertSame(NULL, $route);
    }

}

