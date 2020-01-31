<?php


namespace Kernel;

use Kernel\Request as Request;
use Kernel\Response as Response;
use Kernel\MiddlewareInterface as MiddlewareInterface;
use Closure;

class Middleware
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

    public function __construct($globalMiddleware = null, $routeMiddleware = null)
    {
        $this->configureMiddleware($globalMiddleware, $routeMiddleware);
    }

    public function handle(Request $request, Response $response)
    {
        $this->configureArrayToExecute($request);

        if (!empty(self::$middlewareToExecute)) {
            if ($this->executeMiddleware($request, $response) instanceof Response) {
                $this->send($response);
                die();
            }
        }
    }

    private function executeMiddleware(Request $request, Response $response)
    {
        $functionToExecute = $this->configureFunctionToExecute(function (Closure $nextClosure, MiddlewareInterface $middleware) ## It will return function that returns execution of user-handle method
        {
            return function (Request $request, Response $response) use ($nextClosure, $middleware) {
                return $middleware->handle($request, $response, $nextClosure);
            };
        },
            function (Request $request, Response $response) {
                return true;
            }
        );
        return $functionToExecute($request, $response);
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
     * @param \Kernel\Request $request
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

    private function configureMiddleware(&$globalMiddleware, &$routeMiddleware)
    {
        if (!is_null($globalMiddleware) and !is_null($routeMiddleware)) {
            self::$routeMiddleware = $routeMiddleware;
            self::$globalMiddleware = $globalMiddleware;
        }
    }

    private function send(Response $response)
    {
        return $response();
    }

}
