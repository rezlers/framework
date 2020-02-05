<?php


namespace Kernel\Services;


interface Mailer
{
    public function __construct($configuration);  ## for configuration

    public function mail($email, $subject, $msg, $from, $replyTo, $name);
}