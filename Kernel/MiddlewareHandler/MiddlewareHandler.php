<?php


namespace Kernel\MiddlewareHandler;

use Kernel\Container\ServiceContainer;
use Kernel\Exceptions\MiddlewareException;
use Kernel\Request\Request as Request;
use Kernel\MiddlewareHandler\MiddlewareInterface as MiddlewareInterface;
use Kernel\Request\RequestInterface;
use Kernel\Response\ResponseInterface;
use Closure;

class MiddlewareHandler
{

    protected static $globalMiddleware;

    protected static $routeMiddleware;
    /**
     * @var MiddlewareInterface[]
     */
    protected static $middlewareToExecute;

    public function __construct($configuration)
    {
        $this->configureMiddleware($configuration);
    }

    /**
     * @param RequestInterface $request
     * @return mixed|null
     * @throws MiddlewareException
     */
    public function handle(RequestInterface $request)
    {
        $this->configureArrayToExecute($request);

        if (!empty(self::$middlewareToExecute)) {
            return $this->executeMiddleware($request);
        }

        return $request;
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     * @throws MiddlewareException
     */
    private function executeMiddleware(RequestInterface $request)
    {
        $functionToExecute = $this->configureFunctionToExecute(function (Closure $nextClosure, MiddlewareInterface $middleware) ## It will return function that returns execution of user-handle method
        {
            return function (Request $request) use ($nextClosure, $middleware) {
                return $middleware->handle($request, $nextClosure);
            };
        },
            function (Request $request) {
                return $request;
            }
        );
        $result = $functionToExecute($request);
        if (!($result instanceof ResponseInterface) and !($result instanceof RequestInterface))
            throw new MiddlewareException("Middleware returned neither Response or Request", 500);

        return $result;
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
     * @param RequestInterface $request
     * @return MiddlewareInterface[]
     * @throws MiddlewareException
     */
    private function configureArrayToExecute(RequestInterface $request)
    {
        self::$middlewareToExecute = array();
        foreach (self::$globalMiddleware as $value) {
            $pathToGlobalMiddleware = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Middleware/' . $value . '.php';
            if (!file_exists($pathToGlobalMiddleware))
                throw new MiddlewareException("Couldn't find globalMiddleware ${value} with path ${pathToGlobalMiddleware}");

            $globalMiddleware = 'App\Middleware\\' . $value;
            self::$middlewareToExecute[] = new $globalMiddleware();
        }
        if (self::$routeMiddleware[$request->getMiddleware()]) {
            $pathToRouteMiddleware =  '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Middleware/' . self::$routeMiddleware[$request->getMiddleware()] . '.php';
            if (!file_exists($pathToRouteMiddleware))
                throw new MiddlewareException("Couldn't find routeMiddleware " . self::$routeMiddleware[$request->getMiddleware()] . " with path ${pathToRouteMiddleware}");

            $routeMiddleware = 'App\Middleware\\' . self::$routeMiddleware[$request->getMiddleware()];
            self::$middlewareToExecute[] = new $routeMiddleware();
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
