<?php
require "../vendor/autoload.php";

$phpRenderer = new  \Time2Code\Framework\Renderer\PHPRenderer();
$twigRenderer = new \Time2Code\Framework\Renderer\TwigRenderer(dirname(__DIR__) . '/templates');

$dependencies = [
  'renderer' => $twigRenderer
];

$app = new \Time2Code\Framework\Application([
    \Time2Code\Modules\Exercises\ExercisesModule::class
], $dependencies);


$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
