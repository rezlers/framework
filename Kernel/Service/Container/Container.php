<?php


namespace Kernel;
use Kernel\ServiceContainer as ServiceContainer;

class SomeContainer extends ServiceContainer
{
    protected function someService ()
    {
        return new someObject();
    }

    protected function anotherService ()
    {
        return anotherObject();
    }

    protected function register ()
    {
        $this->bind($this->someService(), 'someService');
        $this->singleton($this->anotherService(), 'anotherService');
    }
}