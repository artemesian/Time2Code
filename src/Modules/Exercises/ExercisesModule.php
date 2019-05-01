<?php
namespace Time2Code\Modules\Exercises;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;

class ExercisesModule
{
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->router->get('/exercises', [$this, 'index'], 'exercises.index');
        $this->router->get('/exercises/{slug:[a-z\-]+}', [$this, 'show'], 'exercise.show');
        $this->router->get('/exercises/{slug:[a-z\-]+}-{id:[\d]+}', [$this, 'showid'], 'exercise.show.id');
    }

    public function index(ServerRequest $request)
    {
        return "<h1>Bienvenue, Liste des exercices !</h1>";
    }

    public function show(ServerRequestInterface $request)
    {
        return "<h1>Bienvenue sur l'exercice " . $request->getAttribute('slug') . "</h1>";
    }

    public function showid(ServerRequest $request)
    {
        return "<h1> " . $request->getAttribute('id') . " Exercice : "
            . $request->getAttribute('slug') . "</h1>";
    }
}
