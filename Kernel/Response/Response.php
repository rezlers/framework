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