<?php


namespace Kernel\Middleware;

use Kernel\Request;
use Closure;

class SystemMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        echo 'SystemMiddleware';
        return $next($request);
    }
}
