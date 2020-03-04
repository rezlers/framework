<?php

use Kernel\App\App;
use Kernel\Container\Services\Implementations\Router;
use Kernel\Container\Services\RouterInterface;
use Kernel\Request\RequestInterface as Request;
use Kernel\Container\ServiceContainer;
use function Kernel\Helpers\render;

# For custom web routes
$container = new ServiceContainer();
/**
 * @var Router $router
 */
$router = $container->getService('Router');

$router->get('/registration/{registrationHash}', 'RegistrationController@confirmLink');
$router->get('/registration', 'RegistrationController@registration')->setMiddleware(['AuthenticationCheck']);
$router->post('/registration', 'RegistrationController@register');

$router->get('/', 'AuthenticationController@authentication')->setMiddleware(['AuthenticationCheck']);
$router->get('/auth', 'AuthenticationController@authentication')->setMiddleware(['AuthenticationCheck']);
$router->get('/auth/do', 'AuthenticationController@authenticate');
$router->get('/auth/logout', 'AuthenticationController@logout');

$router->get('/main','LinksController@getMainPage');

$router->get('/links', 'LinksController@getUserLinksPage')->setMiddleware(['AuthenticationCheck']);
$router->get('/links/edit/{id}', 'LinksController@getEditLinkPage')->setMiddleware(['AuthenticationCheck']);
$router->get('/links/create', 'LinksController@getCreateLinkPage')->setMiddleware(['AuthenticationCheck']);
$router->get('/links/description/{id}', 'LinksController@getLinkDescriptionPage');
$router->post('/links/edit/{id}', 'LinksController@editLink')->setMiddleware(['AuthenticationCheck']);
$router->post('/links/create', 'LinksController@createLink')->setMiddleware(['AuthenticationCheck']);

$router->get('/account', 'UserController@getAccountMainPage')->setMiddleware(['AuthenticationCheck']);
$router->get('/account/edit', 'UserController@getAccountEditPage')->setMiddleware(['AuthenticationCheck']); ## Will be redirected to /{login}
$router->post('/account/edit', 'UserController@editProfile')->setMiddleware(['AuthenticationCheck']); ## Will be redirected to /{login}
