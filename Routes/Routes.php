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

$router->get('/registration/do/{registrationHash}', 'RegistrationController@confirmLink')->setMiddleware(['AuthenticationCheck']);
$router->get('/registration', 'RegistrationController@registration')->setMiddleware(['AuthenticationCheck']);
$router->post('/registration/do', 'RegistrationController@register');

$router->get('/', 'AuthenticationController@authentication')->setMiddleware(['AuthenticationCheck']);
$router->get('/auth', 'AuthenticationController@authentication')->setMiddleware(['AuthenticationCheck']);
$router->get('/auth/do', 'AuthenticationController@authenticate');
$router->get('/auth/logout', 'AuthenticationController@logout');

$router->get('/main','LinksController@getMainPage')->setMiddleware(['AuthenticationCheck']);

//$router->get('/{login}/{action}', 'UserController')->setMiddleware(['UrlValidation', 'AuthenticationCheck', 'CheckUrlLogin']);
//$router->post('/{login}/{action}', 'UserController')->setMiddleware(['UrlValidation', 'AuthenticationCheck', 'CheckUrlLogin'])//;
$router->get('/account', 'UserController')->setMiddleware(['redirectToAlias']);
$router->get('/account/{action}', 'UserController')->setMiddleware(['redirectToAlias']); ## Will be redirected to /{login}
$router->post('/account/{action}', 'UserController')->setMiddleware(['redirectToAlias']); ## Will be redirected to /{login}

$router->get('/{login}', 'UserController@getAccountMainPage')->setMiddleware(['UrlValidation', 'AuthenticationCheck', 'CheckUrlLogin']);
$router->get('/{login}/edit', 'UserController@getAccountEditPage')->setMiddleware(['UrlValidation', 'AuthenticationCheck', 'CheckUrlLogin']);
$router->post('/{login}/edit', 'UserController@editProfile')->setMiddleware(['UrlValidation', 'AuthenticationCheck', 'CheckUrlLogin']);

//$router->get('/links/{action}/{id}', 'LinksController')->setMiddleware(['AuthenticationCheck']);
//$router->post('/links/{action}/{id}', 'LinksController')->setMiddleware(['AuthenticationCheck']);

$router->get('/links', 'LinksController@getUserLinksPage')->setMiddleware(['AuthenticationCheck']);
$router->get('/links/edit/{id}', 'LinksController@getLinkEditPage')->setMiddleware(['AuthenticationCheck']);
$router->get('/links/create/{id}', 'LinksController@getLinkCreatePage')->setMiddleware(['AuthenticationCheck']);
$router->post('/links/edit/{id}', 'LinksController@editLink')->setMiddleware(['AuthenticationCheck']);
$router->post('/links/create/{id}', 'LinksController@createLink')->setMiddleware(['AuthenticationCheck']);


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