<?php
namespace Framework;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;

class Application
{

    private $modules = [];
    private $router;

    public function __construct(array $modules = null)
    {
        if ($modules !== null) {
            foreach ($modules as $module) {
                $this->modules[] = new $module();
            }
        }
        $this->router = new Router();
    }

    public function run(ServerRequest $request): Response
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === '/') {
            return (new Response())
               ->withStatus(301)
               ->withHeader('Location', substr($uri, 0, -1));
        }

        $this->router->get('/blog', function () {
        }, 'blog');
        $this->router->get('/community', function () {
        }, 'community');

        $route = $this->router->match($request);

        if ($route && $route->getName() === "blog") {
            return new Response(200, [], "Time2Code - <h1>page obtenue par le système de routage ! </h1>");
        }
        if ($route && $route->getName() === "community") {
            return new Response(200, [], "Time2Code - <h1>Bienvenue sur la communauté...</h1>");
        }


        return new Response(404, [], "<h1>Erreur 404</h1>");
    }
}
