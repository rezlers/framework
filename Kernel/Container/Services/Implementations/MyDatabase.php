<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\Container\Services\DatabaseInterface;
use PDO;

class MyDatabase implements DatabaseInterface
{
    protected static $configuration;
    /**
     * @var PDO
     */
    protected $currentConnection;

    public function __construct($configuration)
    {
        $this->setConnection($configuration);
    }

    private function setConnection($configuration)
    {
        if (!self::$configuration){
            self::$configuration = $configuration;
        }
    }

    public function connection() ## for multiply db connections. If there is only one connection, then it's senseless
    {
        $host = self::$configuration['host'];
        $username = self::$configuration['username'];
        $database = self::$configuration['database'];
        $password = self::$configuration['password'];
        $driver = self::$configuration['driver'];

        $connectionString = $driver . ':host=' . $host . ';dbname=' . $database;

        $this->currentConnection = new PDO($connectionString, $username, $password);
        return $this;
    }

    public function statement ($statement, $args = [])
    {
        $preparedStatement = $this->currentConnection->prepare($statement);
        return $preparedStatement->execute($args);
    }



}
