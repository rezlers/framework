<?php


namespace App\Middleware;

use Kernel\Request;
use Kernel\Response;
use Kernel\MiddlewareInterface;
use Closure;
use Kernel\ServiceContainer;

class UserMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        $container = new ServiceContainer();
        $container->getService('Logger')->info('User middleware has passed');
        return $next($request);
    }
}
