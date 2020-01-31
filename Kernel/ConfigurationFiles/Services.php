<?php

$services = [
    'Router' => [
        'namespace' => 'Kernel\Router',
        'args' => [],
        'type' => 'singleton'
    ],
    'Middleware' => [
        'namespace' => 'Kernel\Middleware',
        'args' => [],
        'type' => 'singleton'
    ],
    'Controller' => [
        'namespace' => 'Kernel\Controller',
        'args' => [],
        'type' => 'singleton'
    ],
    'DB' => [
        'namespace' => 'Kernel\Services\DataBase',
        'args' => [],
        'type' => 'any'
    ],
    'Logger' => [
        'namespace' => 'Kernel\Services\Logger',
        'args' => [],
        'type' => 'any'
    ]
];

