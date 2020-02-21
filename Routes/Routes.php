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

$router->get('/registration/{action}/{registrationHash}', 'RegistrationController')->setMiddleware(['AuthenticationCheck']);
$router->post('/registration/{action}', 'RegistrationController')->setMiddleware(['AuthenticationCheck']);

$router->get('/auth/{action}', 'AuthenticationController')->setMiddleware(['AuthenticationCheck']);
$router->post('/auth/{action}', 'AuthenticationController')->setMiddleware(['AuthenticationCheck']);
$router->get('/', 'AuthenticationController')->setMiddleware(['AuthenticationCheck']);

$router->get('/main','LinksController')->setMiddleware(['AuthenticationCheck']);

$router->get('/{login}/{action}', 'UserController')->setMiddleware(['UrlValidation', 'AuthenticationCheck', 'CheckUrlLogin']);
$router->post('/{login}/{action}', 'UserController')->setMiddleware(['UrlValidation', 'AuthenticationCheck', 'CheckUrlLogin']);
$router->get('/account/{action}', 'UserController')->setMiddleware(['AuthenticationCheck', 'CheckUrlLogin']); ## Will be redirected to /{login}
$router->post('/account/{action}', 'UserController')->setMiddleware(['AuthenticationCheck', 'CheckUrlLogin']); ## Will be redirected to /{login}

$router->get('/links/{action}/{id}', 'LinksController')->setMiddleware(['AuthenticationCheck']);
$router->post('/links/{action}/{id}', 'LinksController')->setMiddleware(['AuthenticationCheck']);



//$router->get('/auth', 'AuthenticationController')->setMiddleware(['AuthenticationCheck']);
//
//$router->get('/', 'AuthenticationController')->setMiddleware(['AuthenticationCheck']);
//
//$router->get('/registration', 'RegistrationController')->setMiddleware(['AuthenticationCheck']);
//
//$router->get('/registration/do/{registrationHash}', 'RegistrationController');
//
//$router->post('/registration/do', 'RegistrationController');
//
//$router->get('/auth/do', 'AuthenticationController'); ## authentication and authorization are in one controller