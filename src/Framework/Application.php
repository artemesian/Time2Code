<?php
namespace Time2Code\Framework;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application
{

    private $modules = [];
    private $router;

    public function __construct(array $modules = null, $dependencies = [])
    {
        $this->router = new Router();
        if ($modules !== null) {
            foreach ($modules as $module) {
                $this->modules[] = new $module($this->router, $dependencies['renderer']);
            }
        }
            $dependencies['renderer']->globals('router', $this->router);
    }

    /**
     *
     * @param ServerRequestInterface $request
     * @return Response
     */
    public function run(ServerRequestInterface $request): Response
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === '/') {
            return (new Response())
               ->withStatus(301)
               ->withHeader('Location', substr($uri, 0, -1));
        }

        $route = $this->router->match($request);

        if (is_null($route)) {
            return new Response(404, [], "<h1>Erreur 404</h1>");
        }


        $params = $route->getParams();

        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
            return $request->withAttribute($key, $params[$key]);
        }, $request);

        $response = call_user_func_array($route->getCallback(), [$request]);

        if (is_string($response)) {
            return new Response('200', [], $response);
        } elseif ($response instanceof ResponseInterface) {
            return $response;
        }
    }
}
