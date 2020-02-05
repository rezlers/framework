<?php


namespace Kernel;

class Service
{
    private $namespace;
    private $type;
    private $nickname;
    private $configuration;
    private $instance;

    public function __construct($namespace, $nickname, $type, $configuration)
    {
        $this->namespace = $namespace;
        $this->nickname = $nickname;
        $this->type = $type;
        $this->configuration = $configuration;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        $configuration = $this->getConfiguration($this->configuration);
        if ($this->type == 'singleton') {
            if ($this->instance)
                return $this->instance;
            if (! is_null($configuration))
                $this->instance = new $this->namespace($configuration);
            else
                $this->instance = new $this->namespace();

            return $this->instance;
        }
        if (! is_null($configuration))
            return new $this->namespace($configuration);
        else
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

    private function getConfiguration($filename)
    {
        if (is_null($filename))
            return null;
        $pathToFile = $_SERVER['DOCUMENT_ROOT'];
        $pathToFile .= '/../Kernel/ConfigurationFiles/' . $filename . '.php';
        return require $pathToFile;
    }

}