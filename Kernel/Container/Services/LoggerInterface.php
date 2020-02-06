<?php


namespace Kernel\Container\Services;


interface LoggerInterface
{
    public function __construct($configuration);  ## for configuration

    public function emergency($message);

    public function alert($message);

    public function error($message);

    public function warning($message);

    public function notice($message);

    public function info($message);

    public function critical($message);

}