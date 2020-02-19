<?php


namespace Kernel\Exceptions;


use Kernel\Container\ServiceContainer;
use Throwable;

class MigrationHandlerException extends \Exception implements FrameworkExceptionInterface
{
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct("MigrationHandlerException: ${message}", $code, $previous);
    }

}