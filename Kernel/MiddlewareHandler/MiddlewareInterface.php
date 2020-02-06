<?php


namespace Kernel\MiddlewareHandler;

use Kernel\Request\Request;


interface MiddlewareInterface
{
    public function handle(Request $request, \Closure $next);
}