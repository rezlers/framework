<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\Services\RouteInterface;
use Kernel\Request\Request;

class Route implements RouteInterface
{
    public $url;  ## Maybe in request UPD It can't, because it's senseless
    public $httpMethod;  ## Maybe in request UPD It can't, because this is 'static' http-method that allows user to reserve this url for current http-method
    public $callable;
    public $paramsNum;  ## Maybe in request UPD It can't, because it's senseless
    public $pathLength;  ## Maybe in request UPD It can't, because it's senseless

    public $reg_exp = '/{.*}/';

    private $middleware;

    public function __construct($httpMethod, $url, $callable)
    {
        $this->setUrl($url);

        $this->httpMethod = $httpMethod;  ## Constructing http method

        $this->callable = $callable;  ## Constructing callable object

        $this->setParamsNum();  ## If there are no params then 0 will be returned

        $this->setPathLength();

    }

    public function middleware($key) : void
    {
        $this->middleware = $key;
    }

    /**
     * @return mixed
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

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
        return null;
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
}