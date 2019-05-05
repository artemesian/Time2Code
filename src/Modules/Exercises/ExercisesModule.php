<?php
namespace Time2Code\Modules\Exercises;

use Time2Code\Framework\Renderer\RendererInterface;
use Time2Code\Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class ExercisesModule
{
    private $router;
    private $renderer;

    public function __construct(Router $router, RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('exercises', __DIR__ . '/views');

        $this->router = $router;
        $this->router->get('/exercises', [$this, 'index'], 'exercises.index');
        $this->router->get('/exercises/{slug:[a-zA-Z\-0-9]+}', [$this, 'show'], 'exercise.show');
        $this->router->get('/exercises/{slug:[a-zA-Z\-0-9]+}/id={id:[\d]+}', [$this, 'showid'], 'exercise.show.id');
    }

    public function index(ServerRequest $request)
    {
        return $this->renderer->render('@exercises/index');
    }

    public function show(ServerRequestInterface $request)
    {
        return $this->renderer->render('@exercises/show', [
            'slug' => $request->getAttribute('slug')
        ]);
    }

    public function showid(ServerRequest $request)
    {
        sleep(4);
        return $this->renderer->render('@exercises/showid', [
            'id' => $request->getAttribute('id'),
            'slug' => $request->getAttribute('slug')
        ]);
    }
}
