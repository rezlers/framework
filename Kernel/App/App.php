<?php


namespace Kernel;

use Kernel\Router as Router;
use Kernel\Middleware as Middleware;
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
     * @var \Kernel\Request
     */
    private $request;
    /**
     * @var Response
     */
    private $response;
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct(Request $request, Response $response)
    {
        $this->response = $response;
        $this->request = $request;
        $this->configureContainer();
        $this->configureRouter();
        $this->configureMiddleware();
    }

    public function handle()
    {
        $route = $this->router->getRoute($this->request);  ## Change method to not mixed return or change method to getRoute. Done

        if (! is_null($route)) {
            $this->request->setRoute($route);  ## Put all such logic to setRoute method. Done
            $this->middleware->handle($this->request, $this->response);
            $callable = $route->callable;
            $callable($this->request);
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

}
