<?php
use Kernel\Request\Request as Request;
use Kernel\Container\Services\ResponseInterface;
use Kernel\Container\ServiceContainer;
# For custom web routes
$container = new ServiceContainer();
$router = $container->getService('Router');

$router->get('/user1/{id}/film/{number}', function (Request $request) {
    $container = new ServiceContainer();
    $response = $container->getService('ResponseInterface');

    return $response;
});
$router->get('/user1/21/film/{number}', function (Request $request) {
    $container = new ServiceContainer();
    $response = $container->getService('ResponseInterface');
    $response->write('Closure has passed');
    return $response;
})->middleware('userMW');

$router->get('/user1/22/film/{number}', 'MyController')->middleware('userMW');


