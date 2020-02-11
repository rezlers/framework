<?php


namespace Kernel\Response;


use Kernel\Request\RequestInterface;

interface ResponseHandlerInterface
{
    public function handle($response, RequestInterface $request) : void;
}