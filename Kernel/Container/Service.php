<?php


namespace Kernel;

class Service
{
    private $namespace;
    private $type;
    private $nickname;
    private $instance;

    public function __construct($namespace, $nickname, $type)
    {
        $this->namespace = $namespace;
        $this->nickname = $nickname;
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        if ($this->type == 'singleton') {
            if ($this->instance)
                return $this->instance;
            $this->instance = new $this->namespace();
            return $this->instance;
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