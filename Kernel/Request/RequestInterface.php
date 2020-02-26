<?php


namespace Kernel\Request;


interface RequestInterface
{

    /**
     * @return array
     */
    public function getParams() : array;

    /**
     * @param string $paramKey
     * @return mixed
     */
    public function getParam(string $paramKey);

    /**
     * @param string $key
     * @param $param
     * @return mixed
     */
    public function addParam(string $key, $param) : RequestInterface;

    /**
     * @return array
     */
    public function getReqParams() : array ;

    /**
     * @return string
     */
    public function getPath() : string;

    /**
     * @return string
     */
    public function getHttpMethod() : string;

    /**
     * @return array
     */
    public function getUrlParams() : array;

    /**
     * @return array
     */
    public function getMiddleware() : array;

    /**
     * @param callable $callable
     */
    public function setCallable(callable $callable): void;

    /**
     * @param array $urlParams
     */
    public function setUrlParams(array $urlParams): void;

    /**
     * @param array $middlewareList
     */
    public function setMiddleware(array $middlewareList): void;

    /**
     * @param $key
     * @param $param
     */
    public function setParam(string $key, $param): void;

    /**
     * @return callable
     */
    public function getCallable();

}