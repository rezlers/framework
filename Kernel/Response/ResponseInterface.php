<?php


namespace Kernel\Response;


interface ResponseInterface
{
    public function getStatusCode() : int;

    public function setStatusCode(int $statusCode) : self;

    public function getHeaders() : array;

    public function setHeader(string $header) : self;

    public function getBody() : string;

    public function write(string $str) : self;
}