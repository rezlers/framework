<?php


namespace Kernel\App;

use Kernel\Container\Services\Implementations\Router as Router;
use Kernel\MiddlewareHandler\MiddlewareHandler as MiddlewareHandler;
use Kernel\CallableHandler\CallableHandler;
use Kernel\Request\Request as Request;
use Kernel\Container\Services\Implementations\Response as Response;
use Kernel\Container\ServiceContainer as ServiceContainer;
use Kernel\Response\ResponseHandler;

class App
{
    /**
     * @var Router
     */
    private $router;
    /**
     * @var MiddlewareHandler
     */
    private $middlewareHandler;
    /**
     * @var CallableHandler
     */
    private $callableHandler;
    /**
     * @var Request
     */
    private $request;
    /**
     * @var ResponseHandler
     */
    private $responseHandler;
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct(Request $request)
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
        $route = $this->router->getRoute($this->request);

        if ($route) {
            $this->request->setRoute($route);

            $result = $this->middlewareHandler->handle($this->request);
            if ($result instanceof Response)
                $this->responseHandler->handle($result);
            elseif ($result instanceof Request) {
                $result = $this->callableHandler->handle($result);
                $this->responseHandler->handle($result);
            }
            $this->responseHandler->handle($this->container->getService('ResponseInterface')->setStatusCode(500));
        } else {
            $this->responseHandler->handle($this->container->getService('ResponseInterface')->setStatusCode(404));
        }
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

    private function configureRouter()
    {
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
