<?php


namespace Kernel\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private static $configuration;

    /**
     * @var PHPMailer
     */
    private static $mailer;

    public function __construct($mail = null, $configuration = null)
    {
        $this->configureMailer($mail, $configuration);
    }

    public function mail($email, $subject, $msg, $from = 'from@example.com', $replyTo = 'replyto@example.com', $name = 'First Last')
    {
        self::$mailer->setFrom($from, $name);

        self::$mailer->addReplyTo($replyTo, $name);

        self::$mailer->addAddress($email);

        self::$mailer->Subject = $subject;

        self::$mailer->msgHTML($msg);

//        self::$mailer->AltBody = 'This is a plain-text message body';

        if (!self::$mailer->send()) {
            echo "Mailer Error: " . self::$mailer->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }

    private function configureMailer($mail, $configuration)
    {
        if (! is_null($configuration))
            self::$configuration = $configuration;

        if(! is_null($mail)) {
            self::$mailer = $mail;

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
    }

}