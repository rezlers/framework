<?php


namespace Kernel\CallableHandler;

use Kernel\Request\Request as Request;
use Kernel\Response\ResponseInterface;

interface ControllerInterface
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request);
}