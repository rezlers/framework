<?php


namespace Kernel\MiddlewareHandler;

use Kernel\Container\ServiceContainer;
use Kernel\Request\Request as Request;
use Kernel\Response\Response as Response;
use Kernel\MiddlewareHandler\MiddlewareInterface as MiddlewareInterface;
use Closure;

class MiddlewareHandler
{
    /**
     * @var MiddlewareInterface[]
     */
    protected static $globalMiddleware;
    /**
     * @var MiddlewareInterface[]
     */
    protected static $routeMiddleware;
    /**
     * @var MiddlewareInterface[]
     */
    protected static $middlewareToExecute;

    public function __construct($configuration)
    {
        $this->configureMiddleware($configuration);
    }

    public function handle(Request $request)
    {
        $this->configureArrayToExecute($request);

        if (!empty(self::$middlewareToExecute)) {
            return $this->executeMiddleware($request);
        }
        $container = new ServiceContainer();
        return $container->getService('Response');
    }

    private function executeMiddleware(Request $request)
    {
        $functionToExecute = $this->configureFunctionToExecute(function (Closure $nextClosure, $middleware) ## It will return function that returns execution of user-handle method
        {
            return function (Request $request) use ($nextClosure, $middleware) {
                return $middleware->handle($request, $nextClosure);
            };
        },
            function (Request $request) {
                return null;
            }
        );
        return $functionToExecute($request);
    }

    private function configureFunctionToExecute(Closure $nextWrapper, Closure $destinationWrapper)
    {
        if (!empty(self::$middlewareToExecute))
            $currentMiddleware = array_pop(self::$middlewareToExecute);
        $closureToBuild = $nextWrapper($destinationWrapper, $currentMiddleware);

        while (!empty(self::$middlewareToExecute)) {
            $currentMiddleware = array_pop(self::$middlewareToExecute);
            $closureToBuild = $nextWrapper($closureToBuild, $currentMiddleware);
        }

        return $closureToBuild;
    }

    /**
     * @param Request $request
     * @return MiddlewareInterface[]
     */
    private function configureArrayToExecute(Request $request)
    {
        self::$middlewareToExecute = array();
        foreach (self::$globalMiddleware as $value) {
            self::$middlewareToExecute[] = new $value();
        }
        if (self::$routeMiddleware[$request->getRoute()->getMiddleware()]) {
            self::$middlewareToExecute[] = new self::$routeMiddleware[$request->getRoute()->getMiddleware()]();
        }
        return self::$middlewareToExecute;
    }

    private function configureMiddleware($configuration)
    {
        if (!self::$routeMiddleware and !self::$routeMiddleware) {
            self::$routeMiddleware = $configuration['routeMiddleware'];
            self::$globalMiddleware = $configuration['globalMiddleware'];
        }
    }


}
