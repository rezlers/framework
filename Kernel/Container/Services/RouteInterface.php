<?php


namespace Kernel\Container\Services;


use Kernel\Request\Request;

interface RouteInterface
{

    ## To get callable from router
    public function createCallable() : callable;

    ## To bind middleware to route
    public function setMiddleware(array $middlewareKeys) : void;

    ## To get middleware that bind to route instance

    /**
     * @return string[]
     */
    public function getMiddleware() : array;

    ## To parse url from request object and get params from it
    public function getParams(string $url) : array;

    ## To check that get method from Router instance returned valid route
    public function isValid() : bool;

}