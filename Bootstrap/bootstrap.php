<?php

use Kernel\Router;
use Kernel\App;
use Kernel\Request;
use Kernel\ServiceContainer;
use Kernel\Containers\DataBase;

require __DIR__ . "/../Kernel/Router/Route.php";

require __DIR__ . "/../Kernel/Router/Router.php";
$router = new router();

require __DIR__ . "/../Routes/Routes.php";

require __DIR__ . "/../Kernel/Request/Request.php";
$request = new request($_REQUEST, $_SERVER['REQUEST_METHOD']);

require __DIR__ . '/../Kernel/ConfigurationFiles/Services.php';  ## $services array
require __DIR__ . '/../Kernel/ConfigurationFiles/DataBaseConnection.php';  ## $connection array
require __DIR__ . '/../Kernel/Service/ServiceContainer.php';
require __DIR__ . '/../Kernel/Service/Service.php';
## There will be autoload func
require __DIR__ . '/../Kernel/Service/Containers/DataBase.php';
$container = new ServiceContainer($services);
$DB = new DataBase($connection);

require __DIR__ . "/../Kernel/App/App.php";
$app = new app($router, $request);



unset($DB);
unset($container);