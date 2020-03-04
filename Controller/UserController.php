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
use Kernel\Request\RequestInterface;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\abort;
use function Kernel\Helpers\redirect;
use function Kernel\Helpers\render;

class UserController implements ControllerInterface
{
    /**
     * @param RequestInterface $request
     * @return bool|false|string
     * @throws ModelException
     */
    public function getAccountMainPage(RequestInterface $request)
    {
        $user = User::getById($_SESSION['userId']);
        $request->addParam('userData', [
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'login' => $user->getLogin()
        ]);
        return render('AccountMain.php');
    }

    /**
     * @param RequestInterface $request
     * @return bool|false|string
     * @throws ModelException
     */
    public function getAccountEditPage(RequestInterface $request)
    {
        $user = User::getById($_SESSION['userId']);
        $request->addParam('userData', [
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'login' => $user->getLogin()
        ]);
        return render('AccountEdit.php');
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ModelException
     */
    public function editProfile(RequestInterface $request)
    {
        $user = User::getById($_SESSION['userId']);
        $params = $request->getParams();
        if (isset($params['password']) and $params['password'] != '') {
            if ($params['repeatedPassword'] != $params['password']) {
                $request->addParam('errorMessage', 'Repeated password does not match with new password');
                $request->addParam('userData', [
                    'email' => $params['email'],
                    'firstName' => $params['firstName'],
                    'lastName' => $params['lastName']
                ]);
                return render('AccountMain.php');
            }
        }
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
                $request->addParam('userData', [
                    'email' => $params['email'],
                    'firstName' => $params['firstName'],
                    'lastName' => $params['lastName']
                ]);
                $request->addParam('errorMessage', 'Email '. $params['email'] .' is already exists');
                return render('AccountMain.php');
            }
            $user->setEmail($params['email']);
        }
        if (isset($params['password']) and $params['password'] != '')
            $user->setPassword(md5($params['password']));
        $user->save();
        return redirect('/account');
    }
}