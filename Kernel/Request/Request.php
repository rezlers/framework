<?php


namespace Kernel;


class Request
{
    public $url;
    public $http_method;
    public $params;

    public function __construct($request, $http_method)
    {
        $this->http_method = $http_method;

        $this->set_params($request);

        $this->set_path($request);
    }

    private function set_params ($request)
    {
        $this->params = array();
        foreach ($request as $key => $value) {
            if ($key != 'path') {
                $this->params[$key] = $value;
            }
        }
    }

    private function set_path ($request) {
        if (is_null($request['path'])) {
            $this->url = '/';
        } else {
            $this->url = '/' . $request['path'];
        }
    }

}