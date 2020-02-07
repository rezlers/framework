<?php


namespace App\controller;

use Kernel\App\App;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Request\Request;
use Kernel\Helpers;
use Kernel\Container\ServiceContainer;

class UserController implements ControllerInterface
{
    public function handle(Request $request)
    {
        $response = App::Response();
        $request->addParam('key', 'value');
        $response->write(Helpers\render('Login.php', $request));
        return $response;
    }
}