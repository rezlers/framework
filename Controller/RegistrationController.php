<?php


namespace App\controller;


use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyDatabase;
use Kernel\Container\Services\MailerInterface;
use Kernel\Request\Request;
use function Kernel\Helpers\getResource;
use function Kernel\Helpers\redirect;
use function Kernel\Helpers\render;

class RegistrationController implements ControllerInterface
{
    /**
     * @var MyDatabase
     */
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
        if (!is_null($request->getParam('registrationHash'))) {
            return $this->confirmLink($request);
        }
        return $this->sendRegistrationLetter($request);
    }

    private function configureInstance()
    {
        $container = new ServiceContainer();
        $this->connection = $container->getService('Database')->connection();
    }

    private function confirmLink (Request $request)
    {
        $hash = $request->getParam('registrationHash');
        $result = $this->connection->statement('SELECT hash, user_id FROM registration_links WHERE hash = ?', [$hash]);
        if ($result === false) {
            return $this->errorFinishPage('Something went wrong. Please try again later', 'Cant execute SELECT hash FROM registration_links');
        }
        $links = $result->fetchAll();
        $result = $this->connection->statement('UPDATE users SET confirmation = true WHERE id = ?', [$links[0]['user_id']]);
        if ($result === false) {
            return $this->errorFinishPage('Something went wrong. Please try again later', 'Cant execute UPDATE users SET confirmation = true WHERE user_id = ? with params: ' . $links[0]['user_id']);
        }
        $result = $this->connection->statement('DELETE FROM registration_links WHERE user_id = ?', [$links[0]['user_id']]);
        if ($result === false) {
            return $this->errorFinishPage('Something went wrong. Please try again later', 'Cant execute SELECT hash FROM registration_links');
        }
        $request->addParam('ResponseMessage', 'Congratulations! You have ended registration');
        return render('FinishPage.php');
    }

    private function sendRegistrationLetter (Request $request)
    {
        $container = new ServiceContainer();
        /** @var MailerInterface $mailer */
        $mailer = $container->getService('Mailer');
        $registrationHash = md5(date('Y-m-d H:i:s') . $request->getParam('login'));
        $request->addParam('registrationHash',$registrationHash);
        $registrationLetter = getResource('Letters/RegistrationLetter.php');
        $result = $mailer->mail($request->getParam('email'), 'Registration letter',$registrationLetter);
        if ($result === false) {
            return $this->errorFinishPage('Something went wrong. Please check if your input email is valid', 'Something goes wrong with "mail" method with email ' . $request->getParam('email'));
        }
        $reqParams = $request->getParams();
        $userDataToInsert = [$reqParams['firstName'], $reqParams['lastName'], $reqParams['login'], $reqParams['email'], $reqParams['password']];
        $result = $this->connection->statement('INSERT INTO users (first_name, last_name, login, email, password) VALUES (?, ?, ?, ?, ?)', $userDataToInsert);
        if ($result === false) {
            return $this->errorFinishPage('Something went wrong. Please try again later',
                'Cant execute INSERT INTO users (first_name, last_name, login, email, password, confirmation) VALUES (?, ?, ?, ?, ?, ?). Params: ' . implode('|', $userDataToInsert));
        }
        $userId = $this->connection->statement('SELECT id FROM users WHERE (login = ?)', [$reqParams['login']])->fetchAll()[0][0];
        $result = $this->connection->statement('INSERT INTO registration_links (user_id, hash) VALUES (?, ?)', [$userId, $registrationHash]);
        if ($result === false) {
            return $this->errorFinishPage('Something went wrong. Please check if your input data is valid', "Can't insert hash value ${registrationHash} into registration_links table. User email is " . $request->getParam('email'));
        }
        $container->getService('Logger')->info('Send letter to ' . $request->getParam('email') . ', insert hash into registration_links table and insert user data into users table');
        $request->addParam('ResponseMessage', 'Congratulations! Letter was sent to tour email. Please check it to finish registration');
        return render('FinishPage.php');
    }

    private function errorFinishPage (string $responseMessage, string $logMessage = '')
    {
        /**
         * @var Request $request
         */
        global $request;
        global $container;
        $container->getService('Logger')->error($logMessage);
        $request->addParam('ResponseMessage', $responseMessage);
        return render('FinishPage.php');
    }
}