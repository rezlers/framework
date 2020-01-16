<?php


namespace Kernel;


class Request
{
    public $url;
    public $http_method;

    public function __construct($url, $http_method)
    {
        $this->http_method = $http_method;
        $this->url = $url;
    }
}