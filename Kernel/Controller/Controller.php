<?php


namespace Kernel;

use Kernel\Response;
use Kernel\Request;
use Kernel\ControllerInterface;

class Controller
{
    /**
     * @var array
     */
    protected static $controllers;
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct($configurationArray)
    {
        $this->configureController($configurationArray);
    }

    public function handle(Request $request)
    {
        $callable = $this->createCallable($request);
        $result = $this->executeCallable($callable, $request);

        if ($result instanceof Response)
            return $result;
        return $this->container->getService('Response')->write($result);
    }

    private function configureController(&$configurationArray)
    {
        if (! self::$controllers) {
            self::$controllers = $configurationArray;
            $this->container = new ServiceContainer();
        }
    }

    private function executeCallable($callable, Request $request)
    {
        if ($callable instanceof \Closure)
            return $callable($request);
        if ($callable instanceof ControllerInterface)
            return $callable->handle($request);

        return false;
    }

    private function createCallable(Request $request)
    {
        $callable = $request->getRoute()->getCallable();
        if ($callable instanceof \Closure)
            return $callable;

        return new self::$controllers[$callable]();
    }

}