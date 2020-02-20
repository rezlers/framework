<?php


namespace App\controller;


use App\Model\Implementations\Link;
use App\Model\Implementations\User;
use App\Model\UserInterface;
use Kernel\App\App;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Exceptions\ModelException;
use Kernel\Request\Request;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\redirect;
use function Kernel\Helpers\render;

class UserController implements ControllerInterface
{

    public function handle(Request $request)
    {
        try {
            session_start();
            if (isset($_SESSION['userId'])) {
                $user = User::getById($_SESSION['userId']);
                if ($request->getParam('action') == 'edit') {
                    if ($request->getHttpMethod() == 'GET') {
                        return render('AccountEdit.php');
                    } elseif ($request->getHttpMethod() == 'POST') {
                        return $this->editProfile($user);
                    }
                } elseif ($request->getParam('action') == 'create') {
                    if ($request->getHttpMethod() == 'GET') {
                        return render('AccountCreateLink.php');
                    } elseif ($request->getHttpMethod() == 'POST') {
                        return $this->createLink($user);
                    }
                }
                $_SESSION['userData'] = [
                    'email' => $user->getEmail(),
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'login' => $user->getLogin()
                ];
                return render('AccountMain.php');
            }
        } catch (ModelException $e) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error($e->getMessage());
            return abort(500);
        }
        $container = new ServiceContainer();
        $container->getService('Logger')->error('Request passed middleware AuthenticationCheck but does not have "user_id" value');
        return abort(500);
    }

    private function editProfile(UserInterface $user)
    {
        global $request;
        $params = $request->getParams();
        if (isset($params['firstName']) and $params['firstName'] != '')
            $user->setFirstName($params['firstName']);
        if (isset($params['lastName']) and $params['lastName'] != '')
            $user->setLastName($params['lastName']);
        if (isset($params['email']) and $params['email'] != '') {
            try {
                $checkArr = User::getByData('email', $params['email']);
            } catch (ModelException $e) {
                $container = new ServiceContainer();
                $container->getService('Logger')->error($e->getMessage());
                return abort(500);
            }
            if (!empty($checkArr)) {
                $container = new ServiceContainer();
                $container->getService('Logger')->info('Edited email '. $params['email'] .' of user ' . $user->getId() . ' was not unique');
                $_SESSION['userData'] = [
                    'email' => $params['email'],
                    'firstName' => $params['firstName'],
                    'lastName' => $params['lastName']
                ];
                $_SESSION['errorMessage'] = 'Email '. $params['email'] .' is already exists';
                return redirect('/' . $user->getLogin() . '/edit');
            }
            $user->setEmail($params['email']);
        }
        if (isset($params['password']) and $params['password'] != '')
            $user->setPassword(md5($params['password']));
        $user->save();
        return redirect('/' . $user->getLogin());
    }

    private function createLink(UserInterface $user)
    {
        global $request;
        $params = $request->getParams();
        try {
            $link = new Link($params['link'], $params['header'], $params['description'], $params['tag']);
            $link->setUserId($_SESSION['userId']);
            $link->save();
            return render('UserLinks.php');
        } catch (ModelException $e) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error($e->getMessage());
            return abort(500);
        }
    }
}