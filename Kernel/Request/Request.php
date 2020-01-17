<?php


namespace Kernel;


class Request
{
    public $url;
    public $http_method;

    public function __construct($url, $http_method)
    {
        $this->http_method = $http_method;

        if (is_null($url)) {
            $this->url = '/';
        } else {
            $this->url = $url;
        }
    }
}