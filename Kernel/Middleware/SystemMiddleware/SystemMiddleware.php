<?php


namespace Kernel\Middleware;

use Kernel\Request;
use Kernel\Response;
use Kernel\MiddlewareInterface;
use Closure;

class SystemMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Response $response, Closure $next)
    {
        echo 'SystemMiddleware';
        return $next($request, $response);
    }
}
