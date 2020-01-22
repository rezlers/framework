<?php


namespace Kernel;


class Request
{
    public $url;
    public $httpMethod;
    public $params;

    public function __construct($request, $httpMethod)
    {
        $this->httpMethod = $httpMethod;

        $this->setParams($request);

        $this->setPath($request);
    }

    private function setParams ($request)
    {
        $this->params = array();
        foreach ($request as $key => $value) {
            if ($key != 'path') {
                $this->params[$key] = $value;
            }
        }
    }

    private function setPath ($request) {
        if (is_null($request['path'])) {
            $this->url = '/';
        } else {
            $this->url = '/' . $request['path'];
        }
    }

}