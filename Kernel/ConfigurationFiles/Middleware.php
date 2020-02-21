<?php

return $middlewareConfiguration = [
    'globalMiddleware' => [

    ],
    'routeMiddleware' => [
        'userMW' => 'UserMiddleware',
        'AuthenticationCheck' => 'AuthenticationCheckMiddleware',
        'CheckUrlLogin' => 'CheckUrlLoginMiddleware',
        'UrlValidation' => 'UrlValidationMiddleware'
    ]
];