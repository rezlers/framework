<?php


namespace App\controller;

use Kernel\ControllerInterface;
use Kernel\Request;
use Kernel\Response;

class UserController implements ControllerInterface
{
    public function handle(Request $request, Response $response) : Response
    {
        echo 'controller has passed';
        return $response;
    }
}