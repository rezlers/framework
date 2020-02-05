<?php
use Kernel\Request as Request;
use Kernel\Response as Response;
# For custom web routes
$router->get('/user1/{id}/film/{number}', function (Request $request) {
    echo 'a';
    $container = new \Kernel\ServiceContainer();
    $response = $container->getService('Response');
    return $response;
});
$router->get('/user1/21/film/{number}', function (Request $request) {
    $container = new \Kernel\ServiceContainer();
    $response = $container->getService('Response');
    $response->write('Closure has passed');
    return $response;
})->middleware('userMW');

$router->get('/user1/22/film/{number}', 'MyController')->middleware('userMW');


