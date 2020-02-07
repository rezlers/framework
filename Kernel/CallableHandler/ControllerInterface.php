<?php


namespace Kernel\CallableHandler;

use Kernel\Request\Request as Request;
use Kernel\Container\Services\Implementations\Response as Response;
use Kernel\Container\Services\Implementations\ResponseHandler;

interface ControllerInterface
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request);
}