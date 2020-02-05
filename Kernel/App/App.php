<?php


namespace Kernel;

use Kernel\Router as Router;
use Kernel\Middleware as Middleware;
use Kernel\Controller as Controller;
use Kernel\Request as Request;
use Kernel\Response as Response;
use Kernel\ServiceContainer as ServiceContainer;
use Kernel\ResponseHandler;

class App
{
    /**
     * @var \Kernel\Router
     */
    private $router;
    /**
     * @var Middleware
     */
    private $middleware;
    /**
     * @var Controller
     */
    private $controller;
    /**
     * @var \Kernel\Request
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
        $this->configureResponseHandler();
        $this->configureContainer();
        $this->configureRouter();
        $this->configureMiddleware();
        $this->configureController();
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
        }
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

    private function configureRouter()
    {
        $this->router = $this->container->getService('Router');
    }

    private function configureMiddleware()
    {
        $this->middleware = $this->container->getService('Middleware');
    }

    private function configureController()
    {
        $this->controller = $this->container->getService('Controller');
    }

    private function configureResponseHandler()
    {
        $this->responseHandler = new ResponseHandler();
    }
}
