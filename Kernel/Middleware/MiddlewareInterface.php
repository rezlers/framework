<?php


namespace Kernel;

use Kernel\Request as Request;
use Kernel\Response as Response;
use Closure;

interface MiddlewareInterface
{
    public function handle(Request $request, Response $response, Closure $next);
}