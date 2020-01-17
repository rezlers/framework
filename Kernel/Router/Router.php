<?php


namespace Kernel;

use \Kernel\Request as Request;

class Router
{
    public $routes = array(array());

    private $reg_exp = '/{.*}/';

    private function get_url_params($app_url)
    {
        $url_parts = explode('/', $app_url);
        $params = array();
        foreach ($url_parts as $value) {
            if (preg_match($this->reg_exp, $value)) {
                $params[] = trim($value, '{}');
            }
        }
        return $params;
    }

    private function is_equal($app_url, $request_url, $is_url_params)
    {
        if ($is_url_params) {
            $app_url_parts = explode('/', trim($app_url, '/'));
            $request_url_parts = explode('/', trim($request_url, '/'));

            if (count($app_url_parts) == count($request_url_parts)) {
                foreach ($app_url_parts as $key => $value) {
                    if (!preg_match($this->reg_exp, $value)) {
                        if ($value == $request_url_parts[$key]) {
                            continue;
                        } else {
                            return false;
                        }
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            if ($app_url == $request_url) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function is_exists(Request $request)
    {
        # first priority is to look throw not-parametres url's
        foreach ($this->routes as $key => $value) {
            if (count($value[2]) == 0) {
                if ($this->is_equal($value[1], $request->url, false)) {
                    if ($value[0] == $request->http_method) {
                        return true;
                    }
                }
            }
        }
        # second priority is to look throw parametres url's
        foreach ($this->routes as $key => $value) {
            if (count($value[2]) == 0) {
                if ($this->is_equal($value[1], $request->url, true)) {
                    if ($value[0] == $request->http_method) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function get($app_url, $callable)
    {
        $this->routes[] = ['GET', $app_url, $this->get_url_params($app_url), $callable];
    }
}