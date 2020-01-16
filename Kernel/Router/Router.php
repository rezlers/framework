<?php


namespace Kernel;
use \Kernel\Request as Request;

class Router
{
    public $routes = array();

    public function is_exists (Request $request)
    {
        $string_to_check = $request->http_method.'|'.$request->url;
        return in_array($string_to_check, array_keys($this->routes));
    }

    public function get($url, $callable)
    {
        $this->routes['get|'.$url] = $callable;
    }
}