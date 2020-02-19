<?php


namespace App\controller;


use App\Model\Implementations\User;
use Kernel\App\App;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Exceptions\ModelException;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\render;

class UserController implements ControllerInterface
{

    public function handle(Request $request)
    {
        try {
            session_start();
            if (isset($_SESSION['userId'])) {
                $user = User::getById($_SESSION['userId']);
                return render('AccountMain.php');
            }
        } catch (ModelException $e) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error($e->getMessage());
            return abort(500);
        }
        return render('AccountMain.php');
    }
}