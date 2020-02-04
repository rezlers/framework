<?php

use Kernel\Router;
use Kernel\App;
use Kernel\Request;
use Kernel\Response;
use Kernel\ServiceContainer;
use Kernel\Services\DataBase;
use Kernel\Services\Logger;
use Kernel\Middleware;
use Kernel\Controller;
use Kernel\Services\Mailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//class MyAutoloader
//{
//    public static function requireDirectory($dir)
//    {
//        foreach (glob($dir . "*.php") as $filename) {
//            require_once $filename;
//        }
//    }
//}

require __DIR__ . '/../vendor/autoload.php';
$phpMailer = new PHPMailer();

require __DIR__ . "/../Kernel/Router/Route.php";

require __DIR__ . "/../Kernel/Router/Router.php";
$router = new router();

require __DIR__ . "/../Routes/Routes.php";

require __DIR__ . "/../Kernel/Request/Request.php";
$request = new Request($_REQUEST, $_SERVER['REQUEST_METHOD']);

require __DIR__ . "/../Kernel/Response/Response.php";
$response = new Response();

## Auto require
//MyAutoloader::requireDirectory(__DIR__ . '/../Kernel/ConfigurationFiles/');
require __DIR__ . '/../Kernel/ConfigurationFiles/Services.php';  ## $services array
require __DIR__ . '/../Kernel/ConfigurationFiles/DataBaseConnection.php';  ## $connection array
require __DIR__ . '/../Kernel/ConfigurationFiles/Logger.php';  ## $logger array
require __DIR__ . "/../Kernel/ConfigurationFiles/Controller.php"; ## $controllers array
require __DIR__ . "/../Kernel/ConfigurationFiles/Mailer.php"; ## $configuration array

require __DIR__ . '/../Kernel/Container/ServiceContainer.php';
require __DIR__ . '/../Kernel/Container/Service.php';
## There will be autoload func

## Auto require
//MyAutoloader::requireDirectory(__DIR__ . '/../Kernel/Container/Services/');
require __DIR__ . '/../Kernel/Container/Services/DataBase.php';
require __DIR__ . '/../Kernel/Container/Services/Logger.php';
require __DIR__ . '/../Kernel/Container/Services/Mailer.php';

## Middleware
require __DIR__ . "/../Kernel/ConfigurationFiles/Middleware.php"; ## $globalMiddleware array, $routeMiddleware array
require __DIR__ . "/../Kernel/Middleware/Middleware.php";
require __DIR__ . "/../Kernel/Middleware/MiddlewareInterface.php";

## Auto require
//MyAutoloader::requireDirectory(__DIR__ . '/../Middleware/');
require __DIR__ . "/../Middleware/SystemMiddleware.php";
require __DIR__ . "/../Middleware/UserMiddleware.php";

$middleware = new Middleware($globalMiddleware, $routeMiddleware);  ## Middleware object will store in container

## Controller
require __DIR__ . "/../Kernel/Controller/Controller.php";
require __DIR__ . "/../Kernel/Controller/ControllerInterface.php";
$controller = new Controller($controllers);

## Auto require
//MyAutoloader::requireDirectory(__DIR__ . '/../Controller');
require __DIR__ . "/../Controller/UserController.php";

## Auto require
require __DIR__ . '/../Model/User.php';

$container = new ServiceContainer($services);
$DB = new DataBase($connection);
$logger = new Logger($logger);
$mailer = new Mailer($phpMailer, $configuration);

require __DIR__ . '/../Kernel/Helpers/Helpers.php';

require __DIR__ . "/../Kernel/App/App.php";
$app = new app($request, $response);



unset($DB);
unset($container);
unset($logger);
unset($middleware);
unset($controller);
unset($mailer);
unset($phpMailer);