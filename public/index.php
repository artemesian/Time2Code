<?php
require "../vendor/autoload.php";

$renderer = new \Time2Code\Framework\Renderer\Renderer();
$renderer->addPath(__DIR__ . '/views');

$dependencies = [
  'renderer' => $renderer
];

$app = new \Time2Code\Framework\Application([
    \Time2Code\Modules\Exercises\ExercisesModule::class
], $dependencies);


$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
