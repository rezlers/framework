<?php


namespace Kernel;

use \Kernel\Request as Request;
use \Kernel\Route as Route;

class Router
{
    public $routes = array();

    public function is_exists(Request $request)
    {
        # first priority is to look throw not-parametres url's
        foreach ($this->routes as $key => $value) {
            if (count($value->params) == 0) {
                if ($value->is_equal($request->url)) {
                    if ($value->http_method) {
                        return true;
                    }
                }
            }
        }
        # second priority is to look throw parametres url's
        foreach ($this->routes as $key => $value) {
            if (count($value->params) != 0) {
                if ($value->is_equal($request->url)) {
                    if ($value->http_method) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function get($app_url, $callable)
    {
        $this->routes[] = new Route('GET', $app_url, $callable);
    }
}