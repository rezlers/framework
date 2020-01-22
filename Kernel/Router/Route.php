<?php


namespace Kernel;


class Route
{
    public $url;
    public $httpMethod;
    public $callable;
    public $params;
    public $pathLength;
    public $requestParams;

    private $reg_exp = '/{.*}/';

    public function __construct($httpMethod, $url, $callable)
    {
        $this->setUrl($url);

        $this->httpMethod = $httpMethod;  ## Constructing http method

        $this->callable = $callable;  ## Constructing callable object

        $this->setUrlParams();  ## If there are no url params then empty array is returned

        $this->setPathLength();

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
    private function setUrlParams()
    {
        $urlParts = explode('/', $this->url);
        $params = array();
        foreach ($urlParts as $value) {
            if (preg_match($this->reg_exp, $value)) {
                $params[] = trim($value, '{}');
            }
        }
        $this->params = $params;
    }

    private function setPathLength()
    {
        $this->pathLength = explode('/', trim($this->url, '/'));
    }

    public function getUrlParams($requestUrl)
    {
        $params = array();
        if ($this->isEqual($requestUrl)) {
            $appUrlParts = explode('/', trim($this->url, '/'));
            $requestUrlParts = explode('/', trim($requestUrl, '/'));
            foreach ($appUrlParts as $key => $value) {
                if (preg_match($this->reg_exp, $value)) {
                    $params[trim($value, '{}')] = $requestUrlParts[$key];

                }
            }
        }
        $params = array_merge($params, $this->requestParams); ## Merge url params and request params
        return $params;
    }

    public function getCallable()
    {
        if (gettype($this->callable) != 'string') {
            return $this->callable;
        }
        # It'll have more complex structure, but now it's unnecessary
        return new $this->callable();
    }

    public function isEqual($requestUrl)
    {
        if (count($this->params) != 0) {
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
}