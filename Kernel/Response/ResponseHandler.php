<?php


namespace Kernel\Response;
use Kernel\Container\Services\ResponseInterface;

class ResponseHandler
{
    public function handle(ResponseInterface $response)
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