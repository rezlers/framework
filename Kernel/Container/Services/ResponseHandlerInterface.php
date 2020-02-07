<?php


namespace Kernel\Container\Services;


interface ResponseHandlerInterface
{
    public function handle(ResponseInterface $response) : void;
}