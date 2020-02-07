<?php


namespace Kernel\CallableHandler;


use Kernel\Request\RequestInterface;
use Kernel\Response\ResponseInterface;

interface CallableHandlerInterface
{
    public function handle(RequestInterface $request) : ResponseInterface;
}