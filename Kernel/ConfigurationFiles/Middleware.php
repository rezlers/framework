<?php

return $middlewareConfiguration = [
    'globalMiddleware' => [
        'SessionStartMiddleware'
    ],
    'routeMiddleware' => [
        'userMW' => 'UserMiddleware',
        'AuthenticationCheck' => 'AuthenticationCheckMiddleware',
        'CheckUrlLogin' => 'CheckUrlLoginMiddleware',
        'UrlValidation' => 'UrlValidationMiddleware',
        'redirectToAlias' => 'redirectToAliasMiddleware'
    ]
];