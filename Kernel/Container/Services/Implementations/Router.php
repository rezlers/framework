<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\RouteInterface;
use \Kernel\Request\Request as Request;
use Kernel\Container\Services\Implementations\Route as Route;
use Kernel\Container\Services\RouterInterface;

class Router implements RouterInterface
{
    protected static $routes = array();

    public function getRoute(Request $request) : RouteInterface
    {
        $candidates = array();
        foreach (self::$routes as $key => $value) {
            if ($value->isEqual($request->getPath())) {
                if ($value->httpMethod == $request->getHttpMethod()) {
                    $candidates[] = $value;
                }
            }
        }
        if (count($candidates) != 0) {
            $numOfParams = $candidates[0]->paramsNum;
            $minKey = 0;
            foreach ($candidates as $key => $value) {
                if ($value->paramsNum < $numOfParams) {
                    $numOfParams = $value->paramsNum;
                    $minKey = $key;
                }
            }
            return $candidates[$minKey];
        }
        $container = new ServiceContainer();
        $errorRoute = $container->getService('Route');
        return $errorRoute;
    }

    /**
     * @param $appUrl
     * @param $callable
     * @return RouteInterface
     */
    public function get($appUrl, $callable) : RouteInterface
    {
        $newInstance = new Route('GET', $appUrl, $callable);
        self::$routes[] = $newInstance;
        return $newInstance;
    }
}