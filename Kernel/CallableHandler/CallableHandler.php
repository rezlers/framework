<?php


namespace Kernel\CallableHandler;

use Kernel\App\App;
use Kernel\Container\ServiceContainer;
use Kernel\CallableHandler\CallableHandlerInterface;
use Kernel\Exceptions\CallableHandlerException;
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

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws CallableHandlerException
     */
    public function handle(RequestInterface $request) : ResponseInterface
    {
        $result = $this->executeCallable($request);

        return $this->configureResponse($result, $request);
    }

    /**
     * @param RequestInterface $request
     * @return mixed
     * @throws CallableHandlerException
     */
    private function executeCallable(RequestInterface $request)
    {
        $callable = $request->getCallable();
        $result = call_user_func_array($callable, array($request));
        if ($result == false) {
            throw new CallableHandlerException("Callable ${callable} execution ended with false as call_user_func_array returned value");
        }
        return $result;
    }

    /**
     * @param $result
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws CallableHandlerException
     */
    private function configureResponse($result, RequestInterface $request)
    {
        if ($result instanceof ResponseInterface)
            return $result;
        elseif(gettype($result) == 'object' and method_exists($result, '__toString'))
            return App::Response()->write("${result}");

        $callable = $request->getCallable();
        throw new CallableHandlerException("Callable ${callable} return's object ${result} that doesn't support __toString method", 500);
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

}