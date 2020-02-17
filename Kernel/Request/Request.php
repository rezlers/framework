<?php


namespace Kernel\Request;


class Request implements RequestInterface
{
    private $urlParams;

    private $reqParams;

    private $middleware;

    private $callable;

    public function __construct($request, $httpMethod)
    {
        $this->configureRequest($request, $httpMethod);
    }

    /**
     * @return array
     */
    public function getParams() : array
    {
        return array_merge($this->reqParams, $this->urlParams);
    }

    public function getParam(string $paramKey)
    {
        $params = $this->getParams();
        if (!array_key_exists($paramKey, $params))
            return null;
        return $params[$paramKey];
    }

    public function addParam(string $key, $param) : RequestInterface
    {
        $this->reqParams[$key] = $param;
        return $this;
    }

    /**
     * @return array
     */
    public function getReqParams() : array
    {
        return $this->reqParams;
    }

    /**
     * @return string
     */
    public function getPath() : string
    {
        return $this->reqParams['path'];
    }

    /**
     * @return string
     */
    public function getHttpMethod() : string
    {
        return $this->reqParams['http_method'];
    }

    /**
     * @return array
     */
    public function getUrlParams() : array
    {
        return $this->urlParams;
    }

    /**
     * @return string[]
     */
    public function getMiddleware() : array
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
     * @param string[] $middlewareList
     */
    public function setMiddleware(array $middlewareList): void
    {
        $this->middleware = $middlewareList;
    }

    /**
     * @return callable
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