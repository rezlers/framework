<?php


namespace Kernel\Services;


interface DataBase
{
    public function __construct($configuration); ## for configuration

    public function connection();

    public function statement($statement);
}