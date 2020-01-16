<?php


namespace Kernel;
use Kernel\Router;
use Kernel\Request;

class App
{
    public function handle (Request $request)
    {
        #Temporary code. Then it will be in middleware entity. Now it in Router
        $Router->is_exists($request);
    }
}
