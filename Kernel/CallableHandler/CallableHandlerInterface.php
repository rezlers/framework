<?php


namespace Kernel\CallableHandler;


use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;

interface CallableHandlerInterface
{
    public function handle(Request $request) : ResponseInterface;
}