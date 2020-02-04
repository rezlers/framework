<?php


namespace Kernel;


class Response
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    public function __construct()
    {
        $this->configureResponse();
    }

    public function send()
    {
        http_response_code($this->statusCode);
        foreach ($this->headers as $value) {
            header($value);
        }
        echo $this->body;

        die();
    }

    public function sendHeader($header)
    {
        header($header);
    }

    public function error(int $errorCode) ## When view templates will be completed then there will be custom errors handling
    {
        http_response_code($errorCode);
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeader($header)
    {
        $this->headers = array();
        $this->headers[] = $header;
    }

    public function addHeader($header)
    {
        $this->headers[] = $header;
    }

    public function clearHeaders()
    {
        $this->headers = array();
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($str)
    {
        $this->body = $str;
    }

    public function write($str)
    {
        $this->body = $this->body . $str;
    }

    private function configureResponse()
    {
        $this->statusCode = 200;
        $this->headers = array();
        $this->body = '';
    }

}