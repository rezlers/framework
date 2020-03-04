<?php


namespace App\controller;


use App\Model\Implementations\Link;
use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Container\Services\PagerInterface;
use Kernel\Exceptions\ModelException;
use Kernel\Request\Request;
use Kernel\Request\RequestInterface;
use Kernel\Response\ResponseInterface;
use function Kernel\Helpers\redirect;
use function Kernel\Helpers\render;
use App\Model\Implementations\User;

class AuthenticationController implements ControllerInterface
{

    /** @var MyDatabase */
    private $connection;

    public function __construct()
    {
        $this->configureInstance();
    }

    public function authentication(RequestInterface $request)
    {
        return render('AuthPage.php');
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ModelException
     */
    public function authenticate(RequestInterface $request)
    {
        $result = User::getByData('login', $request->getParam('login'));
        session_start();
        if (empty($result)) {
            $request->addParam('userData', [
                'login' => $request->getParam('login')
            ]);
            $request->addParam('errorMessage', 'There is no user with such login and password. Check if your input data is valid');
            return render('AuthPage.php');
        }
        $user = $result[0];
        if ($user->getPassword() != md5($request->getParam('password'))) {
            $request->addParam('userData', [
                'login' => $request->getParam('login')
            ]);
            $request->addParam('errorMessage', 'There is no user with such login and password. Check if your input data is valid');
            return render('AuthPage.php');
        }
        if ($user->getConfirmation() === false){
            $request->addParam('userData', [
                'login' => $request->getParam('login')
            ]);
            $request->addParam('errorMessage', 'You did not confirm your email address');
            return render('AuthPage.php');
        }
        $_SESSION['authentication'] = true;
        $_SESSION['userId'] = $user->getId();
        return redirect('/main');
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function logout(RequestInterface $request)
    {
        $_SESSION['authentication'] = false;
        unset($_SESSION['userId']);
        return redirect('/auth');
    }

    private function configureInstance()
    {
        $container = new ServiceContainer();
        $this->connection = $container->getService('Database')->connection();
    }

//    /**
//     * @param array $links
//     * @return array
//     */
//    private function getPages(array $links): array
//    {
//        /** @var RequestInterface $request */
//        global $request;
//        $container = new ServiceContainer();
//        /** @var PagerInterface $pager */
//        $pager = $container->getService('Pager');
//        if (!is_null($request->getParam('page'))) {
//            return $pager->getPages($request->getParam('page'), count($links), trim($request->getPath(), '/'));
//        }
//        return $pager->getPages(1, count($links), trim($request->getPath(), '/'));
//    }

}