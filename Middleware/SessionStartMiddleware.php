<?php


namespace App\Middleware;


use Kernel\MiddlewareHandler\MiddlewareInterface;
use Kernel\Request\Request;

class SessionStartMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, \Closure $next)
    {
        session_start();
        return $next($request);
    }
}