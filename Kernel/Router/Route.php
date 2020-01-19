<?php


namespace Kernel;


class Route
{
    public $url;
    public $http_method;
    public $callable;
    public $params;
    public $path_length;

    private $reg_exp = '/{.*}/';

    public function __construct($http_method, $url, $callable)
    {
        $this->set_url($url);

        $this->http_method = $http_method;  ## Constructing http method

        $this->callable = $callable;  ## Constructing callable object

        $this->set_url_params();  ## If there are no url params then empty array is returned

        $this->set_path_length();

    }

    private function set_url($url)
    {
        if (is_null($url)) {
            $this->url = '/';
        } else {
            $this->url = $url;
        }
    }

    private function set_url_params()
    {
        $url_parts = explode('/', $this->url);
        $params = array();
        foreach ($url_parts as $value) {
            if (preg_match($this->reg_exp, $value)) {
                $params[] = trim($value, '{}');
            }
        }
        $this->params = $params;
    }

    private function set_path_length()
    {
        $this->path_length = explode('/', trim($this->url, '/'));
    }

    public function get_url_params()
    {
        return $this->params;
    }

    public function get_callable()
    {
        if (gettype($this->callable) != 'string') {
            return $this->callable;
        }
        # It'll have more complex structure, but now it's unnecessary
        return new $this->callable();
    }

    public function is_equal($request_url)
    {
        if (count($this->params) != 0) {
            $app_url_parts = explode('/', trim($this->url, '/'));
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
            if ($this->url == $request_url) {
                return true;
            } else {
                return false;
            }
        }
    }
}