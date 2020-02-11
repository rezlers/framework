<?php


namespace Kernel\Response;

use Kernel\App\App;
use Kernel\Exceptions\CallableHandlerException;
use Kernel\Request\RequestInterface;
use Kernel\Response\ResponseHandlerInterface;
use Kernel\Response\ResponseInterface;
use Throwable;

class ResponseHandler implements ResponseHandlerInterface
{
    /**
     * @param $result
     * @param RequestInterface $request
     * @throws CallableHandlerException
     */
    public function handle($result, RequestInterface $request) : void
    {
        $response = $this->configureResponse($result, $request);
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

    /**
     * @param $result
     * @param RequestInterface $request
     * @return \Kernel\Response\ResponseInterface
     * @throws CallableHandlerException
     */
    private function configureResponse($result, RequestInterface $request)
    {
        if ($result instanceof ResponseInterface)
            return $result;
        elseif(gettype($result) == 'object' and method_exists($result, '__toString'))
            return App::Response()->write("${result}");

        $callable = $request->getCallable();
        throw new CallableHandlerException("Callable ${callable} return's object ${result} that doesn't support __toString method", 500);
    }
}