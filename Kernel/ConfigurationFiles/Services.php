<?php
// Service keys are actually interfaces names

return $services = [
    'Response' => [
        'namespace' => 'Kernel\Response\Response',
        'args' => [],
        'type' => 'any'
    ],
    'Database' => [
        'namespace' => 'Kernel\Container\Services\Implementations\MyDatabase',
        'args' => [],
        'type' => 'any',
        'configuration' => 'DataBaseConnection'
    ],
    'Logger' => [
        'namespace' => 'Kernel\Container\Services\Implementations\MyLogger',
        'args' => [],
        'type' => 'any',
        'configuration' => 'Logger'
    ],
    'Mailer' => [
        'namespace' => 'Kernel\Container\Services\Implementations\PhpMailerWrapper',
        'args' => [],
        'type' => 'singleton',
        'configuration' => 'Mailer'
    ]
];

