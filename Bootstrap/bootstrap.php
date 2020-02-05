<?php

use Kernel\Router;
use Kernel\App;
use Kernel\Request;
use Kernel\Response;
use Kernel\ServiceContainer;
use Kernel\Services\Implementations\MyDatabase;
use Kernel\Services\Implementations\MyLogger;
use Kernel\Middleware;
use Kernel\Controller;
use Kernel\Services\Implementations\PhpMailerWrapper;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . "/../Kernel/Router/Route.php";

require __DIR__ . "/../Kernel/Router/Router.php";
$router = new router();

require __DIR__ . "/../Routes/Routes.php";

require __DIR__ . "/../Kernel/Request/Request.php";
$request = new Request($_REQUEST, $_SERVER['REQUEST_METHOD']);

require __DIR__ . "/../Kernel/Response/Response.php";
require __DIR__ . '/../Kernel/Response/ResponseHandler.php';

require __DIR__ . '/../Kernel/ConfigurationFiles/Services.php';  ## $services array
require __DIR__ . '/../Kernel/ConfigurationFiles/DataBaseConnection.php';  ## $connection array
require __DIR__ . '/../Kernel/ConfigurationFiles/Logger.php';  ## $logger array
require __DIR__ . "/../Kernel/ConfigurationFiles/Controller.php"; ## $controllers array
require __DIR__ . "/../Kernel/ConfigurationFiles/Mailer.php"; ## $configuration array

require __DIR__ . '/../Kernel/Container/ServiceContainer.php';
require __DIR__ . '/../Kernel/Container/Service.php';
## There will be autoload func

require __DIR__ . '/../Kernel/Container/Services/Database.php';
require __DIR__ . '/../Kernel/Container/Services/Logger.php';
require __DIR__ . '/../Kernel/Container/Services/Mailer.php';
require __DIR__ . '/../Kernel/Container/Services/Implementations/MyDatabase.php';
require __DIR__ . '/../Kernel/Container/Services/Implementations/MyLogger.php';
require __DIR__ . '/../Kernel/Container/Services/Implementations/PhpMailerWrapper.php';

## Middleware
require __DIR__ . "/../Kernel/ConfigurationFiles/Middleware.php"; ## $globalMiddleware array, $routeMiddleware array
require __DIR__ . "/../Kernel/Middleware/Middleware.php";
require __DIR__ . "/../Kernel/Middleware/MiddlewareInterface.php";

require __DIR__ . "/../Middleware/SystemMiddleware.php";
require __DIR__ . "/../Middleware/UserMiddleware.php";

## Controller
require __DIR__ . "/../Kernel/Controller/Controller.php";
require __DIR__ . "/../Kernel/Controller/ControllerInterface.php";

require __DIR__ . "/../Controller/UserController.php";

require __DIR__ . '/../Model/User.php';

$container = new ServiceContainer($services);

require __DIR__ . '/../Kernel/Helpers/Helpers.php';

require __DIR__ . "/../Kernel/App/App.php";
$app = new app($request);



unset($container);
