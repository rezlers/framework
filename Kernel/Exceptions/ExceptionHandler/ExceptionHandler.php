<?php


namespace Kernel\Exceptions\ExceptionHandler;

use Kernel\Exceptions;
use Kernel\Response\ResponseInterface;

class ExceptionHandler
{
    public function handle(\Exception $exception) : ResponseInterface
    {
        if ($exception instanceof Exceptions\MiddlewareException) {

        } elseif ($exception instanceof Exceptions\CallableHandlerException) {

        } elseif ($exception instanceof Exceptions\ResponseHandlerException) {

        } elseif ($exception instanceof Exceptions\RouteException) {

        } elseif ($exception instanceof Exceptions\RouterException) {

        } elseif ($exception instanceof Exceptions\ShutdownHandlerException) {

        } else {

        }
    }

}