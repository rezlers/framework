<?php


namespace Kernel\App;

use Kernel\CallableHandler\CallableHandlerInterface;
use Kernel\Container\Services\Implementations\Router as Router;
use Kernel\Request\RequestInterface;
use Kernel\Response\ResponseHandlerInterface;
use Kernel\Container\Services\RouterInterface;
use Kernel\MiddlewareHandler\MiddlewareHandler as MiddlewareHandler;
use Kernel\CallableHandler\CallableHandler;
use Kernel\Request\Request as Request;
use Kernel\Response\Response as Response;
use Kernel\Container\ServiceContainer as ServiceContainer;
use Kernel\Response\ResponseHandler;
use Kernel\Response\ResponseInterface;

class App
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var MiddlewareHandler
     */
    private $middlewareHandler;
    /**
     * @var CallableHandlerInterface
     */
    private $callableHandler;
    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var ResponseHandlerInterface
     */
    private $responseHandler;
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
        $this->configureContainer();
        $this->configureRouter();
        $this->configureMiddleware();
        $this->configureController();
        $this->configureResponseHandler();
    }

    public function handle()
    {
        $route = $this->router->getRoute($this->request); // Begin Router entity. Router is service

        if ($route->isValid()) {
            $this->request->setUrlParams($route->getParams($this->request->getPath()));
            $this->request->setMiddleware($route->getMiddleware());
            $this->request->setCallable($route->createCallable());  // End of Router entity. Callable object(array, func or closure) is configured here. Framework's instance

            $result = $this->middlewareHandler->handle($this->request);  // Middleware entity. Result is mixed(Response, Request). Framework's instance middlewareHandler
            if ($result instanceof ResponseInterface)
                $this->responseHandler->handle($result);  // End of preMVC framework

            elseif ($result instanceof RequestInterface) {
                $result = $this->callableHandler->handle($result);  // Controller entity. Response must be returned. Will be a service
                $this->responseHandler->handle($result);  // Sending and now it responsible for getting shutdown
            }
            $this->responseHandler->handle(App::Response()->setStatusCode(500));  // If middleware entity returned neither Response or Request
        } else {
            $this->responseHandler->handle(App::Response()->setStatusCode(404));  // If there are no suitable route
        }
    }

    public static function Response() : ResponseInterface
    {
        return new Response();
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

    private function configureRouter()
    {
        $pathToRoutes = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Routes/Routes.php';
        require $pathToRoutes;
        $this->router = new Router();
    }

    private function configureMiddleware()
    {
        $pathToFile = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Kernel/ConfigurationFiles/Middleware.php';
        $configuration = require $pathToFile;
        $this->middlewareHandler = new MiddlewareHandler($configuration);
    }

    private function configureController()
    {
        $this->callableHandler = new CallableHandler();
    }

    private function configureResponseHandler()
    {
        $this->responseHandler = new ResponseHandler();
    }
}
