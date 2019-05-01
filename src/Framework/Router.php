<?php
namespace Framework;

use Framework\Router\Route;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

class Router
{
    private $zendFastRouter;

    public function __construct()
    {
        $this->zendFastRouter = new FastRouteRouter();
    }

    public function get(string $path, callable $callback, string $name)
    {
        $this->zendFastRouter->addRoute(new ZendRoute($path, $callback, ['GET'], $name));
    }

    public function match(ServerRequest $request) : ?Route
    {
        $routeResult = $this->zendFastRouter->match($request);
        if ($routeResult->isSuccess()) {
            return new Route(
                $routeResult->getMatchedRouteName(),
                $routeResult->getMatchedMiddleware(),
                $routeResult->getMatchedParams()
            );
        }
        return null;
    }

    public function generateURI(string $name, array $params): ?string
    {
        return $this->zendFastRouter->generateUri($name, $params);
    }
}
