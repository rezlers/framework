<?php
# For custom web routes
# Request params and url params belong to one array $params
$Router->get('/user1/c', function (array $params) {echo $params['a'];});
$Router->get('/user2/b', function (array $params) {echo 'Hello world';});
$Router->get('/user3/a', function (array $params) {echo 'Hello world';});
$Router->get('/user1/{id}/film/{number}', function (array $params) {echo $params['id'], $params['number'];});
$Router->get('/user1/21/film/{number}', function (array $params) {echo $params['number'], $params['a'];});


