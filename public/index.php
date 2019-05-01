<?php
require "../vendor/autoload.php";



$app = new \Framework\Application([
    \Time2Code\Modules\Exercises\ExercisesModule::class
]);


$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
