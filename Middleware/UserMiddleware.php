<?php


namespace App\Middleware;

use Kernel\Request\Request;
use Closure;
use Kernel\Container\ServiceContainer;
use Kernel\MiddlewareHandler\MiddlewareInterface;

class UserMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        $container = new ServiceContainer();
        $container->getService('LoggerInterface')->info('User middleware has passed');
        return $next($request);
    }
}
