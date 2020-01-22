<?php


namespace Kernel;

use Kernel\Route as Route;

class Request
{
    public $url;
    public $httpMethod;
    public $params;

    public function __construct($request, $httpMethod)
    {
        $this->httpMethod = $httpMethod;

        $this->params = $request;

        $this->setPath($request);
    }

    public function setParams (Route $route)
    {
        $params = array();
        if ($route->isEqual($this->url)) {
            $appUrlParts = explode('/', trim($route->url, '/'));
            $requestUrlParts = explode('/', trim($this->url, '/'));
            foreach ($appUrlParts as $key => $value) {
                if (preg_match($route->reg_exp, $value)) {
                    $params[trim($value, '{}')] = $requestUrlParts[$key];

                }
            }
        }
        $params = array_merge($params, $this->params); ## Merge app url params and request params
        return $params;
    }

    private function setPath ($request) {
        if (is_null($request['path'])) {
            $this->url = '/';
        } else {
            $this->url = '/' . $request['path'];
        }
    }

}