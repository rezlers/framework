<?php

$services = [
    'Router' => [
        'namespace' => 'Kernel\Router',
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
        'args' => '',
        'type' => 'any'
    ]
];

