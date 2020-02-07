<?php


namespace Kernel\CallableHandler;

use Kernel\App\App;
use Kernel\Container\ServiceContainer;
use Kernel\CallableHandler\CallableHandlerInterface;
use Kernel\Request\RequestInterface;
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

    public function handle(RequestInterface $request) : ResponseInterface
    {
        $result = $this->executeCallable($request);

        return $this->configureResponse($result, $request);
    }


    private function executeCallable(RequestInterface $request)
    {
        $callable = $request->getCallable();
        return call_user_func_array($callable, array($request));
    }

    private function configureResponse($result, RequestInterface $request)
    {
        if ($result instanceof ResponseInterface)
            return $result;
        elseif(gettype($result) == 'object' and method_exists($result, '__toString'))
            return App::Response()->write("${result}");

        $container = new ServiceContainer();
        $callable = $request->getCallable();
        $container->getService('Logger')->error("Callable ${callable} return's object ${result} that doesn't support __toString method");
        return App::Response()->setStatusCode(500);
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

}