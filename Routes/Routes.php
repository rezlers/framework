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

$router->get('/auth', function (Request $request) {
    $responseHtml = render('AuthPage.php');
    if (isset($_SESSION['userData']))
        unset($_SESSION['userData']);
    if (isset($_SESSION['errorMessage']))
        unset($_SESSION['errorMessage']);
    return $responseHtml;
});

$router->get('/', function (Request $request) {
    $responseHtml = render('AuthPage.php');
    if (isset($_SESSION['userData']))
        unset($_SESSION['userData']);
    if (isset($_SESSION['errorMessage']))
        unset($_SESSION['errorMessage']);
    return $responseHtml;
});

$router->get('/registration', function (Request $request) {
    $responseHtml = render('RegistrationPage.php');
    if (isset($_SESSION['userData']))
        unset($_SESSION['userData']);
    if (isset($_SESSION['errorMessage']))
        unset($_SESSION['errorMessage']);
    return $responseHtml;
});

$router->get('/registration/{registrationHash}', 'RegistrationController');

$router->get('/main','MainPageController')->setMiddleware(['AuthenticationCheck']);

$router->post('/RegistrationController', 'RegistrationController');

$router->get('/AuthenticationController', 'AuthenticationController');






$router->get('/user1/{id}/film/{number}', function (Request $request) {
    $response = App::Response();

    return $response;
});
$router->get('/user1/21/film/{number}', function (Request $request) {
    $response = App::Response();
    $response->write('Closure has passed');
    return $response;
})->setMiddleware(['userMW']);

$router->get('/user1/22/film/{number}', 'MyController')->setMiddleware(['userMW']);