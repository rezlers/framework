<?php


namespace Kernel\Request;

use Kernel\Container\Services\Implementations\Route as Route;
use Kernel\Container\Services\RouteInterface;

class Request
{
    private $urlParams;

    private $reqParams;
    /**
     * @var RouteInterface
     */
    private $route;

    private $middleware;

    private $callable;

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

    public function getParam($param)
    {
        $params = $this->getParams();
        return $params[$param];
    }

    public function addParam($key, $param)
    {
        $this->reqParams[$key] = $param;
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
     * @return string
     */
    public function getMiddleware() : string
    {
        return $this->middleware;
    }

    /**
     * @param mixed $callable
     */
    public function setCallable(callable $callable): void
    {
        $this->callable = $callable;
    }

    /**
     * @param array $urlParams
     */
    public function setUrlParams(array $urlParams): void
    {
        $this->urlParams = $urlParams;
    }

    /**
     * @param mixed $middleware
     */
    public function setMiddleware($middlewareKey): void
    {
        $this->middleware = $middlewareKey;
    }

    /**
     * @return mixed
     */
    public function getCallable()
    {
        return $this->callable;
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