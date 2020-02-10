<?php


namespace Kernel\Exceptions\ExceptionHandler;

use Kernel\App\App;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\LoggerInterface;
use Kernel\Exceptions;
use Kernel\Response\ResponseInterface;

class ExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct()
    {
        $this->configureLogger();
    }

    public function handle(\Exception $exception) : ResponseInterface
    {
        $response = App::response();
        if ($exception instanceof Exceptions\MiddlewareException) {
            $this->logException($exception);
        } elseif ($exception instanceof Exceptions\CallableHandlerException) {
            $this->logException($exception);
        } elseif ($exception instanceof Exceptions\ResponseHandlerException) {
            $this->logException($exception);
        } elseif ($exception instanceof Exceptions\RouteException) {
            $this->logException($exception);
        } elseif ($exception instanceof Exceptions\RouterException) {
            $this->logException($exception);
        } elseif ($exception instanceof Exceptions\ShutdownHandlerException) {
            $this->logException($exception);
        } else {
            $this->logException($exception);
        }
        $response->setStatusCode($exception->getCode());
        return $response;
    }

    private function logException(\Exception $exception) : void
    {
        $exceptionCode = $exception->getCode();
        if ($exceptionCode >= 100 and $exceptionCode < 400) {
            $this->logger->error($exception->getMessage());
        } elseif ($exceptionCode >= 400 and $exceptionCode < 500) {
            $this->logger->critical($exception->getMessage());
        } elseif ($exceptionCode >= 500 and $exceptionCode < 600) {
            $this->logger->alert($exception->getMessage());
        } else {
            $this->logger->error('NotFrameworkException' . $exception->getMessage());  // Not framework exception
        }
    }

    private function configureLogger()
    {
        $container = new ServiceContainer();
        $this->logger = $container->getService('Logger');
    }

}