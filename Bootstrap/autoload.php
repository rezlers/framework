<?php

use Kernel\Router;
use Kernel\App;
use Kernel\Request;

require __DIR__ . "/../Kernel/Router/Route.php";

require __DIR__ . "/../Kernel/Router/Router.php";
$Router = new Router();

require __DIR__ . "/../Kernel/App/App.php";
$App = new App($Router);

require __DIR__ . "/../Kernel/Request/Request.php";
$Request = new Request($_REQUEST, $_SERVER['REQUEST_METHOD']);

require __DIR__ . "/../Routes/Routes.php";


