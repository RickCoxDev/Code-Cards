<?php
require "vendor/autoload.php";

use Monolog\Handler\StreamHandler;

$log = new \Flynsarmy\SlimMonolog\Log\MonologWriter(array(
    'handlers' => array(
        new StreamHandler(date('Y-m-d').'.log'),
    ),
));

$app = new \Slim\Slim(array(
    'debug' => false,
    'log.enabled' => true,
    'log.level' => \Slim\Log::DEBUG,
    'log.writer' => $log
));

$app->hook('slim.after.router', function () use ($app) {
    $request = $app->request;
    $response = $app->response;

    $app->log->debug('Request path: ' . $request->getPathInfo());
    $app->log->debug('Response status: ' . $response->getStatus());
});

$app->get('/hello/:name', function ($name) {
    echo json_encode("Hello $name");
});

$app->run();
?>