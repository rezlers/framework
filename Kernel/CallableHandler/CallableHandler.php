<?php


namespace Kernel\CallableHandler;

use Kernel\App\App;
use Kernel\Container\ServiceContainer;
use Kernel\CallableHandler\CallableHandlerInterface;
use Kernel\Response\Response;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;

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
        return App::Response()->write("${result}");
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