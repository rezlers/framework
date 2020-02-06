<?php


namespace Kernel\Container\Services;


interface RouteInterface
{
    public function createCallable() : callable;

    public function middleware($middlewareKey) : void;

    public function getParams(string $url) : array;

}