<?php


namespace Kernel\Services;


interface Database
{
    public function __construct($configuration); ## for configuration

    public function connection();

    public function statement($statement);
}