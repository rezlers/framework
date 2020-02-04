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

    public function __construct($configurationArray = null)
    {
        $this->configureController($configurationArray);
    }

    public function handle(Request $request, Response $response)
    {
        $callable = $this->createCallable($request, $response);
        if ($this->executeCallable($callable, $request, $response) == false)
            $response->sendError(500); ## error handling. Determinate framework error
        $response->send();
    }

    private function configureController(&$configurationArray)
    {
        if (! is_null($configurationArray))
            self::$controllers = $configurationArray;
    }

    private function executeCallable($callable, Request $request, Response $response)
    {
        if ($callable instanceof \Closure)
            return $callable($request, $response);
        if ($callable instanceof ControllerInterface)
            return $callable->handle($request, $response);

        return false;
    }

    private function createCallable(Request $request, Response $response)
    {
        $callable = $request->getRoute()->getCallable();
        if ($callable instanceof \Closure)
            return $callable;

        return new self::$controllers[$callable]();
    }

}