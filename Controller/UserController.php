<?php


namespace App\controller;

use Kernel\CallableHandler\ControllerInterface;
use Kernel\Request\Request;
use Kernel\Helpers;
use Kernel\Container\ServiceContainer;

class UserController implements ControllerInterface
{
    public function handle(Request $request)
    {
        $container = new ServiceContainer();
        $response = $container->getService('Response');
        $request->addParam('key', 'value');
        $response->write(Helpers\render('Login.php', $request));
        return $response;
    }
}