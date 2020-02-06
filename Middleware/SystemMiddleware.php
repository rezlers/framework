<?php


namespace App\Middleware;

use Kernel\Request\Request;
use Kernel\Response\Response;
use Closure;
use Kernel\Container\ServiceContainer;

class SystemMiddleware
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
