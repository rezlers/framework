<?php
// Service keys are actually interfaces names

return $services = [
    'Response' => [
        'classname' => 'Response',
        'args' => [],
        'type' => 'any',
        'interface' => 'ResponseInterface'
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

