<?php


namespace Kernel\Response;


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
     * @return Response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }


    public function addHeader($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function write($str)
    {
        $this->body = $this->body . $str;
        return $this;
    }

    /**
     * @param string $str
     * @return Response
     */
    public function setBody($str)
    {
        $this->body = $str;
        return $this;
    }
    /**
     * @param string $header
     * @return Response
     */
    public function setHeader($header)
    {
        $this->headers = array();
        $this->headers[] = $header;
        return $this;
    }

    private function configureResponse()
    {
        $this->statusCode = 200;
        $this->headers = array();
        $this->body = '';
    }

}