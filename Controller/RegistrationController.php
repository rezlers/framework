<?php


namespace App\controller;


use Kernel\CallableHandler\ControllerInterface;
use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\MailerInterface;
use Kernel\Request\Request;
use function Kernel\Helpers\getResource;
use function Kernel\Helpers\render;

class RegistrationController implements ControllerInterface
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request)
    {
        $container = new ServiceContainer();
        /** @var MailerInterface $mailer */
        $mailer = $container->getService('Mailer');
        $registrationHash = md5(date('Y-m-d H:i:s') . $request->getParam('login'));
        $request->addParam('registrationLink',$registrationHash);
        $registrationLetter = getResource('Letters/RegistrationLetter.php');
        $result = $mailer->mail($request->getParam('email'), 'Registration letter',$registrationLetter);
        if ($result === false) {
            $container->getService('Logger')->error('Something goes wrong with mail method with email ' . $request->getParam('email'));
            $request->addParam('ResponseMessage', 'Something went wrong. Please check if your input email is valid');
            return render('FinishPage.php');
        }
        $result = $container->getService('Database')->connection()->statement('INSERT INTO registration_links (hash) VALUES ' . "(${registrationHash})");
        if ($result === false) {
            $container->getService('Logger')->error("Can't insert hash value ${registrationHash} into registration_links table. User email is " . $request->getParam('email'));
            $request->addParam('ResponseMessage', 'Something went wrong. Please check if your input data is valid');
            return render('FinishPage.php');
        }
        $container->getService('Logger')->info('Send letter to ' . $request->getParam('email') . ' and insert hash into registration_links table');
        $request->addParam('ResponseMessage', 'Congratulations! Letter was sent to tour email. Please check it to finish registration');
        return render('FinishPage.php');
    }
}