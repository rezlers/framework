<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\CallableHandlerInterface;
use Kernel\Container\Services\Implementations\Response;
use Kernel\Request\Request;
use Kernel\Container\Services\ResponseInterface;

class CallableHandler implements CallableHandlerInterface
{
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct()
    {
        $this->configureContainer();
    }

    public function handle(Request $request) : ResponseInterface
    {
        $result = $this->executeCallable($request);

        if ($result instanceof ResponseInterface)
            return $result;
        return $this->container->getService('ResponseInterface')->write("${result}");
    }


    private function executeCallable(Request $request)
    {
        $callable = $request->getCallable();
        return call_user_func_array($callable, array($request));
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

}