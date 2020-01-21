<?php


namespace Kernel;

use Kernel\Router as Router;
use Kernel\Request as Request;
use Kernel\Route as Route;

class App
{
    private $Router;

    public function __construct(Router $router)
    {
        $this->Router = $router;
    }

    public function handle(Request $request)
    {
        $route = $this->Router->isExists($request);

        if ($route) {
            $route->requestParams = $request->params;
            $callable = $route->callable;
            $callable($route->getUrlParams($request->url));
        }
    }

}
