<?php

use Kernel\Router;
use Kernel\App;
use Kernel\Request;
use Kernel\ServiceContainer;
use Kernel\Services\DataBase;
use Kernel\Services\Logger;

require __DIR__ . "/../Kernel/Router/Route.php";

require __DIR__ . "/../Kernel/Router/Router.php";
$router = new router();

require __DIR__ . "/../Routes/Routes.php";

require __DIR__ . "/../Kernel/Request/Request.php";
$request = new request($_REQUEST, $_SERVER['REQUEST_METHOD']);

require __DIR__ . '/../Kernel/ConfigurationFiles/Services.php';  ## $services array
require __DIR__ . '/../Kernel/ConfigurationFiles/DataBaseConnection.php';  ## $connection array
require __DIR__ . '/../Kernel/ConfigurationFiles/Logger.php';  ## $logger array
require __DIR__ . '/../Kernel/Container/ServiceContainer.php';
require __DIR__ . '/../Kernel/Container/Service.php';
## There will be autoload func
require __DIR__ . '/../Kernel/Container/Services/DataBase.php';
require __DIR__ . '/../Kernel/Container/Services/Logger.php';
$container = new ServiceContainer($services);
$DB = new DataBase($connection);
$logger = new Logger($logger);

require __DIR__ . "/../Kernel/App/App.php";
$app = new app($request);



unset($DB);
unset($container);
unset($logger);