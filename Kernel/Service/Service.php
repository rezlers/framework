<?php


namespace Kernel;
use Kernel\ServiceContainer as ServiceContainer;

class Service
{
    private $namespace;
    private $type;
    private $nickname;

    public function __construct($namespace, $nickname, $type)
    {
        $this->namespace = $namespace;
        $this->nickname = $nickname;
        $this->type = $type;
    }

    public function getInstance()
    {
        if ($this->type == 'singleton') {
            if (ServiceContainer::$services[$this->nickname])
                return ServiceContainer::$services[$this->nickname];
            return new $this->namespace();
        }
        return new $this->namespace();
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function getType()
    {
        return $this->type;
    }

}