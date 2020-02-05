<?php

return $middlewareConfiguration = [
    'globalMiddleware' => [
        'sysMW' => 'App\Middleware\SystemMiddleware'
    ],
    'routeMiddleware' => [
        'userMW' => 'App\Middleware\UserMiddleware'
    ]
];