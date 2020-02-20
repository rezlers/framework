<?php


namespace App\controller;


use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Exceptions\ModelException;
use Kernel\Request\Request;
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

    /**
     * @param Request $request
     * @return mixed
     * @throws ModelException
     */
    public function handle(Request $request)
    {
        if ($request->getParam('action') == 'do') {
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
        $responseHtml = render('AuthPage.php');
        if (isset($_SESSION['userData']))
            unset($_SESSION['userData']);
        if (isset($_SESSION['errorMessage']))
            unset($_SESSION['errorMessage']);
        return $responseHtml;
    }

    private function configureInstance()
    {
        $container = new ServiceContainer();
        $this->connection = $container->getService('Database')->connection();
    }

}