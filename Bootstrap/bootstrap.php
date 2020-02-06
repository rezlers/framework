<?php

use Kernel\Router\Router;
use Kernel\App\App;
use Kernel\Request\Request;
use Kernel\Response\Response;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Container\Services\Implementations\MyLogger;
use Kernel\Middleware\MiddlewareHandler;
use Kernel\Controller\Controller;
use Kernel\Container\Services\Implementations\PhpMailerWrapper;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

spl_autoload_register(function ($classname) {
    $parts = explode('\\', $classname);
    if ($parts[0] == 'Kernel') {
        $pathToFile = $_SERVER['DOCUMENT_ROOT'] . '../' . implode('/', $parts) . '.php';
        require $pathToFile;
    } else {
        $pathToFile = $_SERVER['DOCUMENT_ROOT'] . '../' . implode('/', array_slice($parts, 1)) . '.php';
        require $pathToFile;
    }
});

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

require __DIR__ . "/../Routes/Routes.php";

$request = new Request($_REQUEST, $_SERVER['REQUEST_METHOD']);

require __DIR__ . '/../Kernel/ConfigurationFiles/Services.php';  ## $services array
require __DIR__ . "/../Kernel/ConfigurationFiles/Controller.php"; ## $controllers array

## MiddlewareHandler
require __DIR__ . "/../Kernel/ConfigurationFiles/Middleware.php"; ## $globalMiddleware array, $routeMiddleware array

$container = new ServiceContainer($services);

require __DIR__ . '/../Kernel/Helpers/Helpers.php';

$app = new app($request);



unset($container);
