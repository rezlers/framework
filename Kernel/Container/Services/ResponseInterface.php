<?php


namespace Kernel\Container\Services;


interface ResponseInterface
{

    public function getStatusCode() : int;

    public function setStatusCode(int $statusCode) : self;

    public function getHeaders() : array;

    public function getBody() : string;

    public function write(string $str) : self;

}