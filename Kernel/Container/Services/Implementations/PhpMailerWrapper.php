<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\Implementations\MyLogger;
use Kernel\Container\Services\MailerInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PhpMailerWrapper implements MailerInterface
{
    protected static $configuration;

    /**
     * @var PHPMailer
     */
    private static $mailer;

    /**
     * @var \Kernel\Container\Services\Implementations\MyLogger
     */
    private $logger;

    public function __construct($configuration)
    {
        $this->configureMailer($configuration);
    }

    public function mail($email, $subject, $msg, $from = 'from@example.com', $replyTo = 'replyto@example.com', $name = 'First Last')
    {
        ob_start();
        self::$mailer->setFrom($from, $name);

        self::$mailer->addReplyTo($replyTo, $name);

        self::$mailer->addAddress($email);

        self::$mailer->Subject = $subject;

        self::$mailer->msgHTML($msg);

//        self::$mailer->AltBody = 'This is a plain-text message body';

        if (!self::$mailer->send()) {
            $this->logger->error("PhpMailerWrapper Error: " . self::$mailer->ErrorInfo);
        } else {
            $this->logger->info("Message sent!");
        }
        ob_end_clean();
    }

    private function configureMailer($configuration)
    {
        if (! self::$configuration)
            self::$configuration = $configuration;

        if(! self::$mailer) {
            self::$mailer = new PHPMailer();

            if (self::$configuration['IsSMTP'])
                self::$mailer->isSMTP();

            self::$mailer->SMTPDebug = self::$configuration['SMTPDebug'];

            self::$mailer->Debugoutput = self::$configuration['DebugOutput'];

            self::$mailer->Host = self::$configuration['Host'];

            self::$mailer->Port = self::$configuration['Port'];

            self::$mailer->SMTPSecure = self::$configuration['SMTPSecure'];

            self::$mailer->SMTPAuth = self::$configuration['SMTPAuth'];

            self::$mailer->Username = self::$configuration['Username'];

            self::$mailer->Password = self::$configuration['Password'];
        }

        $container = new ServiceContainer();
        $this->logger = $container->getService('MyLogger');
    }

}