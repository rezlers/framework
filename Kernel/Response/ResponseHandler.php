<?php


namespace Kernel;
use Kernel\Response;

class ResponseHandler
{
    public function handle(Response $response)
    {
        $this->sendResponseCode($response);
        $this->sendHeaders($response);
        $this->sendBody($response);
        $this->shutdownHandler($response);
    }

    private function shutdownHandler(Response $response)
    {
        die();
    }

    private function sendResponseCode(Response $response)
    {
        http_response_code($response->getStatusCode());
    }

    private function sendHeaders(Response $response)
    {
        foreach ($response->getHeaders() as $value) {
            header($value);
        }
    }

    private function sendBody(Response $response)
    {
        echo $response->getBody();
    }
}