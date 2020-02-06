<?php


namespace Kernel\Container\Services;


use Kernel\Request\Request as Request;
use Kernel\Router\Route as Route;

interface RouterInterface
{
    /**
     * @param Request $request
     * @return RouteInterface
     */
    public function getRoute(Request $request) : RouteInterface;

    /**
     * @param $appUrl
     * @param $callable
     * @return RouteInterface
     */
    public function get($appUrl, $callable) : RouteInterface;
}