<?php


namespace Kernel\Response;


interface ResponseHandlerInterface
{
    public function handle(ResponseInterface $response) : void;
}