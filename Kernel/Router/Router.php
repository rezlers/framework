<?php


namespace Kernel;

use \Kernel\Request as Request;
use \Kernel\Route as Route;

class Router
{
    public $routes = array();

    public function isExists(Request $request)
    {
        $candidates = array();
        foreach ($this->routes as $key => $value) {
            if ($value->isEqual($request->url)) {
                if ($value->httpMethod == $request->httpMethod) {
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
        return false;
    }

    /**
     * @param $appUrl
     * @param $callable
     * @return \Kernel\Route
     */
    public function get($appUrl, $callable)
    {
        $newInstance = new Route('GET', $appUrl, $callable);
        $this->routes[] = $newInstance;
        return $newInstance;
    }
}