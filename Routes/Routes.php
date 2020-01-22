<?php
# For custom web routes
# Request params and url params belong to one array $params
$router->get('/user1/c', function (array $params) {echo $params['a'];});
$router->get('/user2/b', function (array $params) {echo 'Hello world';});
$router->get('/user3/a', function (array $params) {echo 'Hello world';});
$router->get('/user1/{id}/film/{number}', function (array $params) {echo $params['id'], $params['number'];});
$router->get('/user1/21/film/{number}', function (array $params) {echo $params['number'], $params['a'];});


