<?php


namespace Kernel;


class Middleware
{
    /**
     * @var array
     */
    protected static $globalMiddleware;
    /**
     * @var array
     */
    protected static $routeMiddleware;

    public function handle($request)
    {
        // Main middleware method that will manage request lifecycle in middleware entity
    }

    private function next($request)
    {
        // Method-manager that responsible for right execution order of middleware sequence
    }
}