<?php


namespace Kernel\Exceptions;


use Kernel\Container\ServiceContainer;
use Throwable;

class DatabaseException extends \Exception implements FrameworkExceptionInterface
{
    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        parent::__construct("DatabaseException: ${message}", $code, $previous);
    }

}