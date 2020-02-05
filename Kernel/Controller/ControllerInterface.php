<?php


namespace Kernel;

use Kernel\Request as Request;
use Kernel\Response as Response;

interface ControllerInterface
{
    /**
     * @param \Kernel\Request $request
     * @return \Kernel\Response
     */
    public function handle(Request $request): Response;
}