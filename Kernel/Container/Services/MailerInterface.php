<?php


namespace Kernel\Container\Services;


interface MailerInterface
{
    public function __construct($configuration);  ## for configuration

    public function mail($email, $subject, $msg, $from, $replyTo, $name);
}