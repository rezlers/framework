<?php

use Kernel\App\App;
use Kernel\Container\Services\RouterInterface;
use Kernel\Request\RequestInterface as Request;
use Kernel\Container\ServiceContainer;
use function Kernel\Helpers\render;

# For custom web routes
$container = new ServiceContainer();
/**
 * @var RouterInterface $router
 */
$router = $container->getService('Router');

$router->get('/auth', 'AuthenticationController')->setMiddleware(['AuthenticationCheck']);

$router->get('/', 'AuthenticationController')->setMiddleware(['AuthenticationCheck']);

$router->get('/registration', 'RegistrationController')->setMiddleware(['AuthenticationCheck']);

$router->get('/registration/do/{registrationHash}', 'RegistrationController');

$router->post('/registration/do', 'RegistrationController');

$router->get('/registration/{action}/{registrationHash}', 'RegistrationController');
$router->post('/registration/{action}/{registrationHash}', 'RegistrationController');

$router->get('/auth/{action}', 'AuthenticationController');
$router->post('/auth/{action}', 'AuthenticationController');

$router->get('/auth/do', 'AuthenticationController'); ## authentication and authorization are in one controller

$router->get('/main','LinksController')->setMiddleware(['AuthenticationCheck']);

$router->get('/{login}', 'UserController')->setMiddleware(['AuthenticationCheck', 'CheckUrlLogin']);
$router->get('/account', 'UserController')->setMiddleware(['AuthenticationCheck', 'CheckUrlLogin']); ## Will be redirected to /{login}

$router->get('/links', 'LinksController')->setMiddleware(['AuthenticationCheck']);
