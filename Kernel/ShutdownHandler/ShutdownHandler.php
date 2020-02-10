<?php


namespace Kernel\ShutdownHandler;


use Kernel\Response\ResponseInterface;

class ShutdownHandler implements ShutdownHandlerInterface
{
    public function shutdown(): void
    {
        die(); // For a while
    }
}