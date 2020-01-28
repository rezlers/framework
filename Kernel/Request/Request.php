<?php


namespace Kernel;

use Kernel\Route as Route;

class Request
{
    private $urlParams;
    private $reqParams;
    private $route;

    public function __construct($request, $httpMethod)
    {
        $this->configureRequest($request, $httpMethod);
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return array_merge($this->reqParams, $this->urlParams);
    }

    /**
     * @return mixed
     */
    public function getReqParams()
    {
        return $this->reqParams;
    }

    public function getPath()
    {
        return $this->reqParams['path'];
    }

    public function getHttpMethod()
    {
        return $this->reqParams['http_method'];
    }

    /**
     * @return mixed
     */
    public function getUrlParams()
    {
        return $this->urlParams;
    }

    /**
     * @return Route
     */
    public function getRoute()
    {
        return $this->route;
    }

    public function setRoute (Route $route)
    {
        $params = array();
        if ($route->isEqual($this->reqParams['path'])) {
            $appUrlParts = explode('/', trim($route->url, '/'));
            $requestUrlParts = explode('/', trim($this->reqParams['path'], '/'));
            foreach ($appUrlParts as $key => $value) {
                if (preg_match($route->reg_exp, $value)) {
                    $params[trim($value, '{}')] = $requestUrlParts[$key];

                }
            }
        }
        $this->urlParams = $params;
        $this->route = $route;
    }

    private function setPath () {
        if (is_null($this->reqParams['path'])) {
            $this->reqParams['path'] = '/';
        } else {
            $this->reqParams['path'] = '/' . $this->reqParams['path'];
        }
    }

    private function configureRequest($request, $httpMethod)
    {
        $this->reqParams = $request;
        $this->reqParams['http_method'] = $httpMethod;
        $this->setPath();
    }

}