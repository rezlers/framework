<?php


namespace Kernel\Container\Services\Implementations;


use Kernel\Container\Services\ResponseContainerInterface;
use Kernel\Response\Response;
use Kernel\Response\ResponseInterface;

class ResponseContainer implements ResponseContainerInterface
{
    public function getInstance(string $serviceKey): ResponseInterface
    {
        return new Response();
    }
}