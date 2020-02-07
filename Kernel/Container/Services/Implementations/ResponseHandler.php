<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\Container\Services\ResponseHandlerInterface;
use Kernel\Container\Services\ResponseInterface;

class ResponseHandler implements ResponseHandlerInterface
{
    public function handle(ResponseInterface $response) : void
    {
        $this->sendResponseCode($response);
        $this->sendHeaders($response);
        $this->sendBody($response);
        $this->shutdownHandler($response);
    }

    private function shutdownHandler(ResponseInterface $response)
    {
        die();
    }

    private function sendResponseCode(ResponseInterface $response)
    {
        http_response_code($response->getStatusCode());
    }

    private function sendHeaders(ResponseInterface $response)
    {
        foreach ($response->getHeaders() as $value) {
            header($value);
        }
    }

    private function sendBody(ResponseInterface $response)
    {
        echo $response->getBody();
    }
}