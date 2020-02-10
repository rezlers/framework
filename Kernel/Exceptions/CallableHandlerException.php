<?php


namespace Kernel\Exceptions;

use Kernel\Container\ServiceContainer;
use Throwable;

class CallableHandlerException extends \Exception implements FrameworkExceptionInterface
{
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct($message = "", $code = 200, Throwable $previous = null)
    {
        parent::__construct("CallableHandlerException: ${message}", $code, $previous);
    }

}