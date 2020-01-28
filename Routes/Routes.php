<?php
use Kernel\Request as Request;
# For custom web routes
$router->get('/user1/{id}/film/{number}', function (Request $request) {
    echo 'a';
    var_dump($request->getReqParams());
    var_dump($request->getParams());
    var_dump($request->getUrlParams());
    var_dump($request->getPath());
    var_dump($request->getHttpMethod());
});
$router->get('/user1/21/film/{number}', function (Request $request) {echo 'b';});


