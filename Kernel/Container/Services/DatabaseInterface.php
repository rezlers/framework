<?php


namespace Kernel\Container\Services;


use Kernel\Exceptions\DatabaseException;

interface DatabaseInterface
{
    public function __construct($configuration); ## for configuration

    public function connection();

    /**
     * @param string $statement
     * @param array $args
     * @return mixed
     * @throws DatabaseException
     */
    public function statement(string $statement, array $args = []);
}