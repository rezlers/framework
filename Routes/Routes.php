<?php

use Kernel\App\App;
use Kernel\Container\Services\RouterInterface;
use Kernel\Request\RequestInterface as Request;
use Kernel\Response\ResponseInterface;
use Kernel\Container\ServiceContainer;
use function Kernel\Helpers\render;

# For custom web routes
$container = new ServiceContainer();
/**
 * @var RouterInterface $router
 */
$router = $container->getService('Router');

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

$router->get('/main', function (Request $request) {
    return render('AuthPage.php');
});
$router->get('/', function (Request $request) {
    return render('AuthPage.php');
});

$router->get('/registration', function (Request $request) {
    return render('RegistrationPage.php');
});

$router->get('/{userName}', 'AccountController');

