<?php


namespace App\controller;


use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Request\Request;
use function Kernel\Helpers\render;

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
     */
    public function handle(Request $request)
    {
        $user = $this->getUser($request);
        if (is_null($user)) {

        }
        return $this->errorFinishPage('', '');
    }

    private function getUser(Request $request)
    {
        $result = $this->connection->statement();
        
    }

    private function errorFinishPage($responseMessage, $logMessage = '')
    {
        /*** @var Request $request */
        global $request;
        return render('FinishPage.php');
    }

    private function configureInstance()
    {
        $container = new ServiceContainer();
        $this->connection = $container->getService('Database')->connection();
    }

}