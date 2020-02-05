<?php


namespace Kernel;

use Kernel\Router as Router;
use Kernel\Middleware as Middleware;
use Kernel\Controller as Controller;
use Kernel\Request as Request;
use Kernel\Response as Response;
use Kernel\ServiceContainer as ServiceContainer;

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
     * @var ServiceContainer
     */
    private $container;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
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

            $this->middleware->handle($this->request);

            // Callbacks are interpreted as controllers too
            $this->controller->handle($this->request);
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

}
