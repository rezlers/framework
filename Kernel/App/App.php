<?php


namespace Kernel;

use Kernel\Router as Router;
use Kernel\Request as Request;
use Kernel\ServiceContainer as ServiceContainer;

class App
{
    private $router;
    private $request;

    public function __construct(Router $router, Request $request)
    {
        $this->router = $router;
        $this->request = $request;
    }

    public function handle()
    {
        $route = $this->router->isExists($this->request);

        if ($route) {
            $callable = $route->callable;
            $callable($this->request->setParams($route));  ## a hundred to one that i will pass request object like a function argument
        }
    }

}
