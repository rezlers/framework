<?php


namespace App\controller;

use Kernel\Controller\ControllerInterface;
use Kernel\Request\Request;
use Kernel\Response\Response;
use Kernel\Helpers;
use Kernel\Container\ServiceContainer;

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