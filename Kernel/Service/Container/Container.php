<?php


namespace Kernel;
use Kernel\ServiceContainer as ServiceContainer;

class SomeContainer extends ServiceContainer
{
    public function __construct($somedepends)
    {
        ## Some code
    }

    ## Some services

    protected function register () ## That registers this class like singleton or not
    {
        $this->bind($this->someService(), 'someService'); ## or
        $this->singleton($this->someService(), 'anotherService');
    }
}
