<?php


namespace Kernel\Response;

use Kernel\Response\ResponseHandlerInterface;
use Kernel\Response\ResponseInterface;

class ResponseHandler implements ResponseHandlerInterface
{
    public function handle(ResponseInterface $response) : void
    {
        $this->sendResponseCode($response);
        $this->sendHeaders($response);
        $this->sendBody($response);
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