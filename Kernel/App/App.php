<?php


namespace Kernel;

use Kernel\Router as Router;
use Kernel\Request as Request;
use Kernel\ServiceContainer as ServiceContainer;

class App
{
    /**
     * @var \Kernel\Router
     */
    private $router;
    /**
     * @var \Kernel\Request
     */
    private $request;
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->configureContainer();
        $this->configureRouter();
    }

    public function handle()
    {
        $route = $this->router->getRoute($this->request);  ## Change method to not mixed return or change method to getRoute. Done

        if (! is_null($route)) {
            $this->request->setRoute($route);  ## Put all such logic to setRoute method. Done
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

}
