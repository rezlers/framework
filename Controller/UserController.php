<?php


namespace App\controller;

use Kernel\ControllerInterface;
use Kernel\Request;
use Kernel\Response;
use Kernel\Helpers;
use Kernel\ServiceContainer;

class UserController implements ControllerInterface
{
    public function handle(Request $request) : Response
    {
        $container = new ServiceContainer();
        $response = $container->getService('Response');
        $request->addParam('key', 'value');
        $response->write(Helpers\render('Login.php', $request));
        return $response;
    }
}