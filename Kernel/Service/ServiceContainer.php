<?php


namespace Kernel;

use Kernel\Service as Service;

class ServiceContainer
{
    protected static $services;  ## Why do we need static protected instead of protected? (symphony)

    public function __construct($configArray = null)
    {
        $this->configureServices($configArray);
    }

    public function getService($serviceNickname)  # If service exists, then return it, else false
    {
        if (self::$services[$serviceNickname])
            return self::$services[$serviceNickname]->getInstance();
        return false;
    }

    public function hasService($serviceNickname)  # Is this service exists? bool
    {
        if (self::$services[$serviceNickname]) {
            return true;
        }
        return false;
    }

    private function configureServices($configArray)
    {
        if (!is_null($configArray)) {
            foreach ($configArray as $key => $value) {
                self::$services[$key] = new Service($value['namespace'], $key, $value['type']);
            }
        }
    }

}

