<?php


namespace Kernel;


class ServiceContainer
{
    protected static $services;  ## Why do we need static protected instead of protected? (symphony)

    public function setService ($service, $serviceNickname)  # If service doesn't exist, then set it with nickname
    {

    }

    public function getService ($service, $variable)  # If service exists, then put it to variable
    {

    }

    public function hasService ($serviceNickname)  # Is this service exists?
    {

    }

    protected function bind($service, $serviceNickname)  ## If you want to create new instance after every call
    {

    }

    protected function singleton($service, $serviceNickname)  ## If you want to work with only one instance
    {

    }

}