<?php


namespace Kernel\Container\Services;


use Kernel\Request\Request as Request;
use Kernel\Request\RequestInterface;
use Kernel\Router\Route as Route;

interface RouterInterface
{
    ## To find route
    /**
     * @param Request $request
     * @return RouteInterface
     */
    public function getRoute(RequestInterface $request) : RouteInterface;

    ## To bind route
    /**
     * @param $appUrl
     * @param $callable
     * @return RouteInterface
     */
    public function get($appUrl, $callable) : RouteInterface;

    /**
     * @param $appUrl
     * @param $callable
     * @return RouteInterface
     */
    public function post($appUrl, $callable) : RouteInterface;
}