<?php
// Service keys are actually interfaces names

return $services = [
    'Response' => [
        'classname' => 'ResponseContainer',
        'args' => [],
        'type' => 'singleton',
        'interface' => 'ResponseContainerInterface'
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
    'Database' => [
        'classname' => 'MyDatabase',
        'args' => [],
        'type' => 'any',
        'configuration' => 'DataBaseConnection',
        'interface' => 'DatabaseInterface'
    ],
    'Logger' => [
        'classname' => 'MyLogger',
        'args' => [],
        'type' => 'singleton',
        'configuration' => 'Logger',
        'interface' => 'LoggerInterface'
    ],
    'Mailer' => [
        'classname' => 'PhpMailerWrapper',
        'args' => [],
        'type' => 'singleton',
        'configuration' => 'MailerInterface',
        'interface' => 'MailerInterface'
    ]
];

