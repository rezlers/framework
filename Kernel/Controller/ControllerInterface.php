<?php


namespace Kernel;

use Kernel\Request;
use Kernel\Response;

interface ControllerInterface
{
    public function handle(Request $request, Response $response);
}