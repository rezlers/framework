<?php

return $middlewareConfiguration = [
    'globalMiddleware' => [

    ],
    'routeMiddleware' => [
        'userMW' => 'UserMiddleware',
        'AuthenticationCheck' => 'AuthenticationCheckMiddleware'
    ]
];