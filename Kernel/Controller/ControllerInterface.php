<?php


namespace Kernel\Controller;

use Kernel\Request\Request as Request;
use Kernel\Response\Response as Response;

interface ControllerInterface
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response;
}