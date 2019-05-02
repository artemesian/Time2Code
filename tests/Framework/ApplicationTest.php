<?php
namespace Tests\Framework;

use Time2Code\Framework\Application;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Time2Code\Modules\Exercises\ExercisesModule;

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

    /*
    public function testBlog():void
    {
        $app = new Application();
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        $this->assertStringContainsString("<h1>Bienvenue sur le Blog</h1>", (string)$response->getBody());
        $this->assertSame(200, $response->getStatusCode());
    }
    */

    public function testExerciseModuleIndex()
    {
        $app = new Application([
            ExercisesModule::class
        ]);
        $request = new ServerRequest('GET', '/exercises');
        $response = $app->run($request);
        $this->assertEquals("<h1>Bienvenue, Liste des exercices !</h1>", (string) $response->getBody());
    }

    public function testExercisesModuleShow()
    {
        $app = new Application([
            ExercisesModule::class
        ]);
        $request = new ServerRequest('GET', '/exercises/first-exercise');
        $response =  $app->run($request);
        $this->assertEquals("<h1>Bienvenue sur l'exercice first-exercise</h1>",
            (string)$response->getBody());
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

