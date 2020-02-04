<?php
use Kernel\Request as Request;
use Kernel\Response as Response;
# For custom web routes
$router->get('/user1/{id}/film/{number}', function (Request $request, Response $response) {
    echo 'a';
    var_dump($request->getReqParams());
    var_dump($request->getParams());
    var_dump($request->getUrlParams());
    var_dump($request->getPath());
    var_dump($request->getHttpMethod());
    return $response;
});
$router->get('/user1/21/film/{number}', function (Request $request, Response $response) {
    $response->write('Closure has passed');
    return $response;
})->middleware('userMW');

$router->get('/user1/22/film/{number}', 'MyController')->middleware('userMW');


