<?php

use Kernel\Container\Services\Implementations\Router;
use Kernel\App\App;
use Kernel\Request\Request;
use Kernel\Container\Services\ResponseInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Container\Services\Implementations\MyLogger;
use Kernel\MiddlewareHandler\MiddlewareHandler;
use Kernel\Container\Services\Implementations\CallableHandler;
use Kernel\Container\Services\Implementations\PhpMailerWrapper;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

spl_autoload_register(function ($classname) {
    $parts = explode('\\', $classname);
    if ($parts[0] == 'Kernel') {
        $pathToFile = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../' . implode('/', $parts) . '.php';
        require $pathToFile;
    } else {
        $pathToFile = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../' . implode('/', array_slice($parts, 1)) . '.php';
        require $pathToFile;
    }
});

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();

require __DIR__ . "/../Routes/Routes.php";

$request = new Request($_REQUEST, $_SERVER['REQUEST_METHOD']);

require __DIR__ . '/../Kernel/ConfigurationFiles/Services.php';  ## $services array

$container = new ServiceContainer($services);

require __DIR__ . '/../Kernel/Helpers/Helpers.php';

$app = new app($request);



unset($container);
