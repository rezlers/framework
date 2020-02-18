<?php


namespace App\controller;


use Kernel\CallableHandler\ControllerInterface;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\render;

class MainPageController implements ControllerInterface
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        return render('MainPage.php');
    }
}