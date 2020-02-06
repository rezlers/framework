<?php


namespace Kernel\App;

use Kernel\Router\Router as Router;
use Kernel\MiddlewareHandler\MiddlewareHandler as MiddlewareHandler;
use Kernel\Controller\Controller as Controller;
use Kernel\Request\Request as Request;
use Kernel\Response\Response as Response;
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
     * @var Controller
     */
    private $controller;
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
        $route = $this->router->getRoute($this->request);  ## Change method to not mixed return or change method to getRoute. Done

        if (! is_null($route)) {
            $this->request->setRoute($route);

            $result = $this->middleware->handle($this->request);
            if ($result instanceof Response)
                $this->responseHandler->handle($result);

            // Callbacks are interpreted as controllers too
            $result = $this->controller->handle($this->request);
            $this->responseHandler->handle($result);
        } else {
            $this->responseHandler->handle($this->container->getService('Response')->setStatusCode(404));
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
        $pathToFile = $_SERVER['DOCUMENT_ROOT'] . '../Kernel/ConfigurationFiles/Middleware.php';
        $configuration = require $pathToFile;
        $this->middlewareHandler = new MiddlewareHandler($configuration);
    }

    private function configureController()
    {
        $this->controller = $this->container->getService('Controller');
    }

    private function configureResponseHandler()
    {
        $this->responseHandler = $this->container->getService('ResponseHandler');
    }
}
