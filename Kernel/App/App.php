<?php


namespace Kernel;

use Kernel\Router as Router;
use Kernel\Request as Request;

class App
{
    private $Router;

    public function __construct(Router $router)
    {
        $this->Router = $router;
    }

    public function handle(Request $request)
    {
        #Temporary code. Then it will be in middleware entity. Now it in Router
        if ($this->Router->is_exists($request)) {
            $string_to_check = $request->http_method.':'.$request->url;
            $this->Router->routes[$string_to_check]();
        }
    }
}
