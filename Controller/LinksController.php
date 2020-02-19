<?php


namespace App\controller;


use Kernel\App\App;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\render;

class LinksController implements ControllerInterface
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        if ($request->getPath() == '/main')
            return render('MainPage.php');
        elseif ($request->getPath() == '/links')
            return render('UserLinks.php');
        return App::Response()->setStatusCode(404);
    }
}