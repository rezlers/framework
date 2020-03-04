<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\RouteInterface;
use Kernel\Container\Services\Implementations\Route as Route;
use Kernel\Container\Services\RouterInterface;
use Kernel\Exceptions\RouteException;
use Kernel\Exceptions\RouterException;
use Kernel\Request\RequestInterface;
use function Kernel\Helpers\redirect;

class Router implements RouterInterface
{
    /**
     * @var Route[]
     */
    protected static $routes = [];
    /**
     * @var Route[]
     */
    protected static $routesToRedirect = [];

    public function getRoute(RequestInterface $request) : RouteInterface
    {
        /*** @var Route[] $candidates */
        $candidates = [];
        foreach (self::$routesToRedirect as $value) {
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
        /*** @var Route[] $candidates */
        $candidates = [];
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
            $requestedRoute = $candidates[$minKey];
            if (!is_null($requestedRoute->getRedirectedRoute()))
                $requestedRoute = $requestedRoute->getRedirectedRoute();
            return $requestedRoute;
        }
        $container = new ServiceContainer();
        $errorRoute = $container->getService('Route');
        return $errorRoute;
    }

    /**
     * @param string $requestedUrl
     * @param string $urlToRedirect
     * @throws RouterException
     * @throws RouteException
     */
    public function redirect(string $requestedUrl, string $urlToRedirect)
    {
        /** @var RequestInterface $request */
        global $request;
        foreach (self::$routes as $value) {
            if ($value->isEqual($urlToRedirect)) {
                if ($request->getHttpMethod() == $value->httpMethod)
                    $redirectedRoute = $value;
            }
        }
        if (!isset($redirectedRoute)) {
            throw new RouterException('There is no url ' . $urlToRedirect);
        }
        $check = false;
        foreach (self::$routes as $value) {
            if ($value->isEqual($requestedUrl)) {
                if ($request->getHttpMethod() == $value->httpMethod) {
                    $value->setRedirectedRoute($redirectedRoute);
                    $check = true;
                }
            }
        }
        if ($check == false) {
            $request->addParam('urlToRedirect', $urlToRedirect);
            self::$routesToRedirect[] = new Route($request->getHttpMethod(), $requestedUrl, function (RequestInterface $request) {return redirect($request->getParam('urlToRedirect'));});
        }
    }

    /**
     * @param $appUrl
     * @param $callable
     * @return RouteInterface
     * @throws RouteException
     */
    public function get($appUrl, $callable) : RouteInterface
    {
        $newInstance = new Route('GET', $appUrl, $callable);
        self::$routes[$appUrl] = $newInstance;
        return $newInstance;
    }

    /**
     * @param $appUrl
     * @param $callable
     * @return RouteInterface
     * @throws RouteException
     */
    public function post($appUrl, $callable) : RouteInterface
    {
        $newInstance = new Route('POST', $appUrl, $callable);
        self::$routes[] = $newInstance;
        return $newInstance;
    }
}