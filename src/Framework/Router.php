<?php
namespace Time2Code\Framework;

use Psr\Http\Message\ServerRequestInterface;
use Time2Code\Framework\Router\Route;
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

    public function match(ServerRequestInterface $request) : ?Route
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
