<?php


namespace App\Model;


use App\Model\Implementations\Resource;

interface ResourceInterface
{
    /**
     * @return ResourceInterface[]
     */
    public static function getResources(): array;

    
}