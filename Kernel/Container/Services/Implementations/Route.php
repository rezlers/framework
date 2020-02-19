<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\Services\RouteInterface;
use Kernel\Exceptions\RouteException;
use Kernel\Request\Request;

class Route implements RouteInterface
{
    public $url;  ## Maybe in request UPD It can't, because it's senseless
    public $httpMethod;  ## Maybe in request UPD It can't, because this is 'static' http-method that allows user to reserve this url for current http-method
    public $callable;
    public $paramsNum;  ## Maybe in request UPD It can't, because it's senseless
    public $pathLength;  ## Maybe in request UPD It can't, because it's senseless

    public $reg_exp = '/{.*}/';

    /**
     * @var array
     */
    private $middlewareList;

    /**
     * Route constructor.
     * @param null $httpMethod
     * @param null $url
     * @param null $callableName
     * @throws RouteException
     */
    public function __construct($httpMethod = null, $url = null, $callableName = null)
    {
        $this->setUrl($url);

        $this->httpMethod = $httpMethod;  ## Constructing http method

        $this->middlewareList = [];

        $this->configureCallable($callableName);  ## Constructing callable object

        $this->setParamsNum();  ## If there are no params then 0 will be returned

        $this->setPathLength();

    }

    /**
     * @return bool
     */
    public function isValid() : bool
    {
        if(!is_null($this->url) and !is_null($this->httpMethod) and !is_null($this->callable))
            return true;
        return false;
    }

    /**
     * @param array $keys
     * @throws RouteException
     */
    public function setMiddleware(array $keys) : void
    {
        $middleware = require '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Kernel/ConfigurationFiles/Middleware.php';
        $routeMiddlewareList = $middleware['routeMiddleware'];
        foreach ($keys as $value) {
            $pathToMiddleware = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Middleware/' . $routeMiddlewareList[$value] . '.php';
            if (is_null($routeMiddlewareList[$value]))
                throw new RouteException("There is no middleware in middleware configuration with key ${$value}", 500);
            if (!file_exists($pathToMiddleware))
                throw new RouteException("There is no middleware with name " . $routeMiddlewareList[$value], 500);
            $this->middlewareList[$value] = $routeMiddlewareList[$value];
        }
    }

    /**
     * @return string[]
     */
    public function getMiddleware() : array
    {
        return $this->middlewareList;
    }

    /**
     * @return callable
     * @throws RouteException
     */
    public function createCallable() : callable
    {
        if ($this->callable instanceof \Closure)
            return $this->callable;
        if (gettype($this->callable) == 'string') {
            $controllers = require '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Kernel/ConfigurationFiles/Controllers.php';
            $instanceNamespace = 'App\Controller\\' . $controllers[$this->callable];
            $instance = new $instanceNamespace();
            $callable = array($instance, 'handle');
            return $callable;
        }
        throw new RouteException("Couldn't create callable in route " . $this->url , 500);
    }

    public function isEqual($requestUrl)
    {
        if ($this->paramsNum != 0) {
            $appUrlParts = explode('/', trim($this->url, '/'));
            $requestUrlParts = explode('/', trim($requestUrl, '/'));

            if (count($appUrlParts) == count($requestUrlParts)) {
                foreach ($appUrlParts as $key => $value) {
                    if (!preg_match($this->reg_exp, $value)) {
                        if ($value == $requestUrlParts[$key]) {
                            continue;
                        } else {
                            return false;
                        }
                    }
                }
                return true;
            } else {
                if (count($appUrlParts) > count($requestUrlParts)) {
                    $this->url = array_slice($appUrlParts, 0, count($requestUrlParts));
                    if ($this->isEqual($requestUrl))
                        return true;
                    $this->url = implode('/',$appUrlParts);
                    return false;
                }
                return false;
            }
        } else {
            if ($this->url == $requestUrl) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getParams(string $url): array
    {
        $params = array();
        if ($this->isEqual($url)) {
            $appUrlParts = explode('/', trim($this->url, '/'));
            $requestUrlParts = explode('/', trim($url, '/'));
            foreach ($appUrlParts as $key => $value) {
                if (preg_match($this->reg_exp, $value)) {
                    $params[trim($value, '{}')] = $requestUrlParts[$key];
                }
            }
        }
        return $params;
    }

    private function setUrl($url)
    {
        if (is_null($url)) {
            $this->url = '/';
        } else {
            $this->url = $url;
        }
    }

    ## Possibly, this function is not need
    private function setParamsNum()
    {
        $urlParts = explode('/', $this->url);
        $params = array();
        foreach ($urlParts as $value) {
            if (preg_match($this->reg_exp, $value)) {
                $params[] = trim($value, '{}');
            }
        }
        $this->paramsNum = count($params);
    }

    private function setPathLength()
    {
        $this->pathLength = explode('/', trim($this->url, '/'));
    }

    /**
     * @param $callable
     * @throws RouteException
     */
    private function configureCallable($callable)
    {
        if (gettype($callable) == 'string') {
            $controllers = require '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Kernel/ConfigurationFiles/Controllers.php';
            if (!$controllers[$callable])
                throw new RouteException("There is no controller in configuration file with key ${callable}", 500);
            $pathToController = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Controller/' . $controllers[$callable] . '.php';
            if (!file_exists($pathToController))
                throw new RouteException("There is no controller in controller folder " . $controllers[$callable] . " with path ${pathToController}", 500);
            $this->callable = $callable;
        } elseif ($callable instanceof \Closure) {
            $this->callable = $callable;
        } elseif (is_null($callable)) {
            $this->callable = $callable;
        } else {
            $errorType = gettype($callable);
            throw new RouteException("Type ${errorType} of callable is not valid in route " . $this->url, 500);
        }

    }
}