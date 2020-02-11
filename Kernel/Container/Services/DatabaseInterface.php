<?php


namespace Kernel\Container\Services;


interface DatabaseInterface
{
    public function __construct($configuration); ## for configuration

    public function connection();

    public function statement(string $statement) : \PDOStatement;

    public function getTable(string $tableName) : array;
}