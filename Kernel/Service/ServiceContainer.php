<?php


namespace Kernel;

use Kernel\Service as Service;

class ServiceContainer
{
    public static $services;  ## Why do we need static protected instead of protected? (symphony)

    public function __construct($configArray)
    {
        $this->configureServices($configArray);
    }

    public function getService($serviceNickname)  # If service exists, then return it, else false
    {
        if (!empty(self::$services[$serviceNickname]['args'])) {
            try {
                $serviceReflection = new \ReflectionClass(self::$services[$serviceNickname]['namespace']);

            } catch (\ReflectionException $e) {
                echo $e;
            }
        }
        return new self::$services[$serviceNickname]['namespace']();
    }

    public function hasService($serviceNickname)  # Is this service exists? bool
    {
        if (self::$services[$serviceNickname]){
            return self::$services[$serviceNickname]->getInstance();
        }
        return false;
    }

    private function configureServices($configArray)
    {
        foreach ($configArray as $key => $value) {
            self::$services[$key] = new Service($value['namespace'], $key, $value['type']);
        }
    }

}

