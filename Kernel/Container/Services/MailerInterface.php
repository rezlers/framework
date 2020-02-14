<?php


namespace Kernel\Container\Services;


interface MailerInterface
{
    public function __construct($configuration);  ## for configuration

    /**
     * @param $email
     * @param $subject
     * @param $msg
     * @return bool
     */
    public function mail($email, $subject, $msg) : bool;
}