<?php


namespace Kernel\Container\Services;


interface Database
{
    public function __construct($configuration); ## for configuration

    public function connection();

    public function statement($statement);
}