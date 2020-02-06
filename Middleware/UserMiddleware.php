<?php


namespace App\Middleware;

use Kernel\Request\Request;
use Kernel\Response\Response;
use Closure;
use Kernel\Container\ServiceContainer;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $container = new ServiceContainer();
        $container->getService('Logger')->info('User middleware has passed');
        return $next($request);
    }
}
