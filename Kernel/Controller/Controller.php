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

    public function __construct($configurationArray)
    {
        $this->configureController($configurationArray);
    }

    public function handle(Request $request)
    {
        $callable = $this->createCallable($request);
        return $this->executeCallable($callable, $request);
    }

    private function configureController(&$configurationArray)
    {
        if (! self::$controllers)
            self::$controllers = $configurationArray;
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