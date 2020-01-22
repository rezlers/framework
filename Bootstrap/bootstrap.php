<?php

use Kernel\Router;
use Kernel\App;
use Kernel\Request;

require __DIR__ . "/../Kernel/Router/Route.php";

require __DIR__ . "/../Kernel/Router/Router.php";
$router = new router();

require __DIR__ . "/../Kernel/Request/Request.php";
$request = new request($_REQUEST, $_SERVER['REQUEST_METHOD']);

require __DIR__ . "/../Kernel/App/App.php";
$app = new app($router, $request);

require __DIR__ . "/../Routes/Routes.php";


