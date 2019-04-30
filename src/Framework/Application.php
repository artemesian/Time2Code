<?php
namespace Framework;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;

class Application
{

    public function __construct()
    {
        //echo "Contruction de l'application !";
    }

    public function run(ServerRequest $request): Response
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === '/') {
            return (new Response())
               ->withStatus(301)
               ->withHeader('Location', substr($uri, 0, -1));
        }

        if ($uri === '/blog') {
            return new Response(200, [], "<h1>Bienvenue sur le Blog</h1>");
        }
        return new Response(404, [], "<h1>Erreur 404</h1>");
    }
}
