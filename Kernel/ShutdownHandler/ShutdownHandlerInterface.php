<?php


namespace Kernel\ShutdownHandler;


use Kernel\Response\ResponseInterface;

interface ShutdownHandlerInterface
{
    public function shutdown() : void;
}