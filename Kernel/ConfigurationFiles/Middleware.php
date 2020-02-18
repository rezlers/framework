<?php

return $middlewareConfiguration = [
    'globalMiddleware' => [
        'sysMW' => 'SystemMiddleware'
    ],
    'routeMiddleware' => [
        'userMW' => 'UserMiddleware',
        'AuthenticationCheck' => 'AuthenticationCheckMiddleware'
    ]
];