<?php


namespace Kernel\Services;

use PDO;

class DataBase
{
    protected static $connectionConfigArray;
    /**
     * @var PDO
     */
    protected $currentConnection;

    public function __construct($connectionConfigArray = null)
    {
        $this->setConnection($connectionConfigArray);
    }

    private function setConnection($connectionConfigArray)
    {
        if (!self::$connectionConfigArray){
            self::$connectionConfigArray = $connectionConfigArray;
        }
    }

    public function connection() ## for multiply db connections. If there is only one connection, then it's senseless
    {
        $host = self::$connectionConfigArray['host'];
        $username = self::$connectionConfigArray['username'];
        $database = self::$connectionConfigArray['database'];
        $password = self::$connectionConfigArray['password'];
        $driver = self::$connectionConfigArray['driver'];

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
