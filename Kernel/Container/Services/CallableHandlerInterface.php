<?php


namespace Kernel\Container\Services;


use Kernel\Request\Request;

interface CallableHandlerInterface
{
    public function handle(Request $request) : ResponseInterface;
}