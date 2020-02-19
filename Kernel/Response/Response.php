<?php


namespace Kernel\Response;


use Kernel\Exceptions\ResponseHandlerException;
use Kernel\Response\ResponseInterface;

class Response implements ResponseInterface
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
     * @return int
     */
    public function getStatusCode() : int
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return Response
     * @throws ResponseHandlerException
     */
    public function setStatusCode(int $statusCode) : ResponseInterface
    {
        if ($statusCode > 600 or $statusCode < 100)
            throw new ResponseHandlerException('Response status code ' . $statusCode . ' does not exists');
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getHeaders() : array
    {
        return $this->headers;
    }


    public function addHeader($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    public function getBody() : string
    {
        return $this->body;
    }

    public function write(string $str) : ResponseInterface
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
     * @return \Kernel\Response\ResponseInterface
     */
    public function setHeader(string $header) : ResponseInterface
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