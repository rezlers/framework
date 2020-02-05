<?php
// Service keys are actually interfaces names

return $services = [
    'Router' => [
        'namespace' => 'Kernel\Router',
        'args' => [],
        'type' => 'singleton'
    ],
    'Middleware' => [
        'namespace' => 'Kernel\Middleware',
        'args' => [],
        'type' => 'singleton',
        'configuration' => 'Middleware'
    ],
    'Controller' => [
        'namespace' => 'Kernel\Controller',
        'args' => [],
        'type' => 'singleton',
        'configuration' => 'Controller'
    ],
    'Response' => [
        'namespace' => 'Kernel\Response',
        'args' => [],
        'type' => 'any'
    ],
    'DataBase' => [
        'namespace' => 'Kernel\Services\Implementations\MyDataBase',
        'args' => [],
        'type' => 'any',
        'configuration' => 'DataBaseConnection'
    ],
    'Logger' => [
        'namespace' => 'Kernel\Services\Implementations\MyLogger',
        'args' => [],
        'type' => 'any',
        'configuration' => 'Logger'
    ],
    'Mailer' => [
        'namespace' => 'Kernel\Services\Implementations\PhpMailerWrapper',
        'args' => [],
        'type' => 'singleton',
        'configuration' => 'Mailer'
    ]
];

