<?php


namespace Kernel\Container;

use Kernel\Container\Service as Service;

class ServiceContainer
{
    /**
     * @var Service[]
     */
    protected static $services;  ## Why do we need static protected instead of protected? (symphony)

    public function __construct($configArray = null)
    {
        $this->configureServices($configArray);
    }

    public function getService($serviceKey)  # If service exists, then return it, else false
    {
        if (self::$services[$serviceKey])
            return self::$services[$serviceKey]->getInstance();
        return null;
    }

    /**
     * @param $serviceKey
     * @return bool
     */
    public function hasService($serviceKey)  # Is this service exists? bool
    {
        if (self::$services[$serviceKey]) {
            return true;
        }
        return false;
    }

    private function configureServices($configArray)
    {
        if (!is_null($configArray)) {
            foreach ($configArray as $key => $value) {
                self::$services[$key] = new Service($value['classname'], $key, $value['type'], $value['configuration']);
            }
        }
    }

}

