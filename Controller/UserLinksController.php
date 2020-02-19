<?php


namespace App\controller;

use Kernel\App\App;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Request\Request;
use Kernel\Helpers;
use Kernel\Container\ServiceContainer;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\render;

class UserLinksController implements ControllerInterface
{
    public function handle(Request $request)
    {
        return render('UserLinks.php');
    }
}