<?php


namespace Kernel\Services;


interface Logger
{
    public function __construct($configuration);  ## for configuration

    public function emergency($message);

    public function alert($message);

    public function error($message);

    public function warning($message);

    public function notice($message);

    public function info($message);

    public function critical($message);

    public function frameworkLog($message);

}