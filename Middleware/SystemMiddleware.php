<?php


namespace App\Middleware;

use Kernel\App\App;
use Kernel\Request\Request;
use Closure;
use Kernel\Container\ServiceContainer;
use Kernel\MiddlewareHandler\MiddlewareInterface;

class SystemMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        $container = new ServiceContainer();
        $container->getService('Logger')->info('SystemMiddleware has passed');
        $response = App::Response();
        if (! $response)
            return $response;
        return 1;
        return $next($request);
    }
}
