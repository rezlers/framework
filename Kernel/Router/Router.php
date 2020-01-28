<?php


namespace Kernel;

use \Kernel\Request as Request;
use \Kernel\Route as Route;

class Router
{
    protected static $routes = array();

    public function getRoute(Request $request)
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
        return null;
    }

    /**
     * @param $appUrl
     * @param $callable
     * @return \Kernel\Route
     */
    public function get($appUrl, $callable)
    {
        $newInstance = new Route('GET', $appUrl, $callable);
        self::$routes[] = $newInstance;
        return $newInstance;
    }
}