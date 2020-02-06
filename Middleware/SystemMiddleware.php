<?php


namespace App\Middleware;

use Kernel\Request\Request;
use Closure;
use Kernel\Container\ServiceContainer;
use Kernel\MiddlewareHandler\MiddlewareInterface;

class SystemMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        echo 'SystemMiddleware';
        $container = new ServiceContainer();
        $response = $container->getService('Response');
        if (! $response)
            return $response; // Может еще null вместо response прийти
        echo 'SystemMiddleware again';
        return $next($request);
    }
}
