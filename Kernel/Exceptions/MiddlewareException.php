<?php


namespace Kernel\Exceptions;


use Kernel\Container\ServiceContainer;
use Throwable;

class MiddlewareException extends \Exception implements FrameworkExceptionInterface
{
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct("MiddlewareException: ${message}", $code, $previous);
    }

}