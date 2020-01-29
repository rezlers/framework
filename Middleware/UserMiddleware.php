<?php


namespace App\Middleware;


use Kernel\Request;
use Closure;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        echo 'UserMiddleware';
        return $next($request);
    }
}