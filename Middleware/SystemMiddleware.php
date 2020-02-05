<?php


namespace App\Middleware;

use Kernel\Request;
use Kernel\Response;
use Kernel\MiddlewareInterface;
use Closure;
use Kernel\ServiceContainer;

class SystemMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        echo 'SystemMiddleware';
        $container = new ServiceContainer();
        $response = $container->getService('Response');
        if (! $response)
            return $response;
        return $next($request);
    }
}
