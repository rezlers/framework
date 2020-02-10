<?php


namespace Kernel\Exceptions;


use Kernel\Container\ServiceContainer;
use Throwable;

class RouterException extends \Exception implements FrameworkExceptionInterface
{
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct($message = "", $code = 200, Throwable $previous = null)
    {
        parent::__construct("RouterException: ${message}", $code, $previous);
    }

}