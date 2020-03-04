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

//    /**
//     * @param Request $request
//     * @return mixed
//     * @throws ModelException
//     */
//    public function handle(Request $request)
//    {
//        if ($request->getParam('action') == 'do') {
//            $result = User::getByData('login', $request->getParam('login'));
//            session_start();
//            if (empty($result)) {
//                $_SESSION['userData'] = [
//                    'login' => $request->getParam('login')
//                ];
//                $_SESSION['errorMessage'] = 'There is no user with such login and password. Check if your input data is valid';
//                return redirect('/auth');
//            }
//            $user = $result[0];
//            if ($user->getPassword() != md5($request->getParam('password'))) {
//                $_SESSION['userData'] = [
//                    'login' => $request->getParam('login')
//                ];
//                $_SESSION['errorMessage'] = 'There is no user with such login and password. Check if your input data is valid';
//                return redirect('/auth');
//            }
//            if ($user->getConfirmation() === false){
//                $_SESSION['userData'] = [
//                    'login' => $request->getParam('login'),
//                ];
//                $_SESSION['errorMessage'] = 'You did not confirm your email address';
//                return redirect('/auth');
//            }
//            $_SESSION['authentication'] = true;
//            $_SESSION['userId'] = $user->getId();
//            return redirect('/main');
//        }
//        $responseHtml = render('AuthPage.php');
//        if (isset($_SESSION['userData']))
//            unset($_SESSION['userData']);
//        if (isset($_SESSION['errorMessage']))
//            unset($_SESSION['errorMessage']);
//        return $responseHtml;
//    }

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
            $_SESSION['userData'] = [
                'login' => $request->getParam('login')
            ];
            $_SESSION['errorMessage'] = 'There is no user with such login and password. Check if your input data is valid';
            return redirect('/auth');
        }
        $user = $result[0];
        if ($user->getPassword() != md5($request->getParam('password'))) {
            $_SESSION['userData'] = [
                'login' => $request->getParam('login')
            ];
            $_SESSION['errorMessage'] = 'There is no user with such login and password. Check if your input data is valid';
            return redirect('/auth');
        }
        if ($user->getConfirmation() === false){
            $_SESSION['userData'] = [
                'login' => $request->getParam('login'),
            ];
            $_SESSION['errorMessage'] = 'You did not confirm your email address';
            return redirect('/auth');
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