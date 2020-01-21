<?php


namespace Kernel;

use \Kernel\Request as Request;
use \Kernel\Route as Route;

class Router
{
    public $routes = array();

    public function is_exists(Request $request)
    {
        $candidates = array();
        foreach ($this->routes as $key => $value) {
            if ($value->is_equal($request->url)) {
                if ($value->http_method == $request->http_method) {
                    $candidates[] = $value;
                }
            }
        }
        if (count($candidates) != 0) {
            $num_of_params = count($candidates[0]->params);
            $min_key = 0;
            foreach ($candidates as $key => $value) {
                if (count($value->params) < $num_of_params) {
                    $num_of_params = count($value->params);
                    $min_key = $key;
                }
            }
            return $candidates[$min_key];
        }
        return false;
    }

    public function get($app_url, $callable)
    {
        $this->routes[] = new Route('GET', $app_url, $callable);
    }
}