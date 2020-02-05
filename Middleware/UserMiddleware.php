<?php


namespace App\Middleware;

use Kernel\Request;
use Kernel\Response;
use Kernel\MiddlewareInterface;
use Closure;

class UserMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        echo 'UserMiddleware';
        return $next($request);
    }
}
