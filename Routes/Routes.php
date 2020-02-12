<?php

use Kernel\App\App;
use Kernel\Request\Request as Request;
use Kernel\Response\ResponseInterface;
use Kernel\Container\ServiceContainer;
# For custom web routes
$container = new ServiceContainer();
$router = $container->getService('Router');

$router->get('/user1/{id}/film/{number}', function (Request $request) {
    $response = App::Response();

    return $response;
});
$router->get('/user1/21/film/{number}', function (Request $request) {
    $response = App::Response();
    $response->write('Closure has passed');
    return $response;
})->middleware('userMW');

$router->get('/user1/22/film/{number}', 'MyController')->setMiddleware('userMW');

$router->get('/migrate', 'MyController')->setMiddleware('userMW');


