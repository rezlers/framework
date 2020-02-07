<?php
// Service keys are actually interfaces names

return $services = [
    'Response' => [
        'classname' => 'Response',
        'args' => [],
        'type' => 'any',
        'interface' => 'ResponseInterface'
    ],
    'Router' => [
        'classname' => 'Router',
        'args' => [],
        'type' => 'singleton',
        'interface' => 'RouterInterface'
    ],
    'Route' => [
        'classname' => 'Route',
        'args' => [],
        'type' => 'any',
        'interface' => 'RouteInterface'
    ],
    'ResponseHandler' => [
        'classname' => 'Route',
        'args' => [],
        'type' => 'any',
        'interface' => 'ResponseHandlerInterface'
    ],
    'CallableHandler' => [
        'classname' => 'Route',
        'args' => [],
        'type' => 'any',
        'interface' => 'CallableHandlerInterface'
    ],
    'DatabaseInterface' => [
        'classname' => 'MyDatabase',
        'args' => [],
        'type' => 'any',
        'configuration' => 'DataBaseConnection',
        'interface' => 'DatabaseInterface'
    ],
    'LoggerInterface' => [
        'classname' => 'MyLogger',
        'args' => [],
        'type' => 'any',
        'configuration' => 'LoggerInterface',
        'interface' => 'LoggerInterface'
    ],
    'MailerInterface' => [
        'classname' => 'PhpMailerWrapper',
        'args' => [],
        'type' => 'singleton',
        'configuration' => 'MailerInterface',
        'interface' => 'ResponseInterface'
    ]
];

