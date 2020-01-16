<?php


namespace Kernel\Router;


class Router
{
    private $routes = array();

    public function get($url, $callable)
    {
        $this->routes['get|'.$url] = $callable;
    }
}