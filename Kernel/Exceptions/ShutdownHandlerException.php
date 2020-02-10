<?php


namespace Kernel\Exceptions;


use Kernel\Container\ServiceContainer;
use Throwable;

class ShutdownHandlerException extends \Exception implements FrameworkExceptionInterface
{
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct($message = "", $code = 200, Throwable $previous = null)
    {
        parent::__construct("ShutdownHandlerException: ${message}", $code, $previous);
        $this->configureContainer();
        $this->container->getService('Logger')->error("ShutdownHandlerException: ${message}");
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }
}