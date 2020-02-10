<?php


namespace Kernel\Container\Services;


use Kernel\Response\ResponseInterface;

interface ResponseContainerInterface
{
    public function getInstance(string $serviceKey) : ResponseInterface;
}