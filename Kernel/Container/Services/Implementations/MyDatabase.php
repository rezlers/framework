<?php


namespace Kernel\Container\Services\Implementations;

use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\DatabaseInterface;
use Kernel\Exceptions\DatabaseException;
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

    /**
     * @return $this
     * @throws DatabaseException
     */
    public function connection() ## for multiply db connections. If there is only one connection, then it's senseless
    {
        try {
            $host = self::$configuration['host'];
            $username = self::$configuration['username'];
            $database = self::$configuration['database'];
            $password = self::$configuration['password'];
            $driver = self::$configuration['driver'];

            $connectionString = $driver . ':host=' . $host . ';dbname=' . $database;

            $this->currentConnection = new PDO($connectionString, $username, $password);
//            $this->currentConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $this;
        } catch (\PDOException $exception) {
            throw new DatabaseException($exception->getMessage());
        }
    }

    /**
     * @param $statement
     * @param array $args
     * @return bool|\PDOStatement
     */
    public function statement (string $statement, array $args = [])
    {
        $preparedStatement = $this->currentConnection->prepare($statement);
        if (!$preparedStatement->execute($args)) {
            $container = new ServiceContainer();
            $container->getService('Logger')->error(implode('|',$preparedStatement->errorInfo()));
            return false;
        }
        return $preparedStatement;
    }

    public function __destruct()
    {
        if ($this->currentConnection)
            $this->currentConnection = null;
    }

//    /**
//     * @param $statement
//     * @param array $args
//     * @return bool|\PDOStatement
//     * @throws DatabaseException
//     */
//    public function statement (string $statement, array $args = [])
//    {
//        $preparedStatement = $this->currentConnection->prepare($statement);
//        if (!$preparedStatement->execute($args))
//            throw new DatabaseException("Couldn't execute statement ${statement} with args ${args}");
//        return $preparedStatement;
//    }
//
//    /**
//     * @param string $tableName
//     * @return array
//     * @throws DatabaseException
//     */
//    public function createTable(string $tableName) : array
//    {
//        if (!$this->currentConnection)
//            throw new DatabaseException("There is no active connection to database");
//        $result = $this->statement('SELECT * FROM :table_name', array(':table_name' => $tableName))->fetchAll();
//    }
//
//    /**
//     * @param $statement
//     * @param array $args
//     * @return bool|\PDOStatement
//     * @throws DatabaseException
//     */
//    public function statement (string $statement, $args = []) : \PDOStatement
//    {
//        try {
//            $preparedStatement = $this->currentConnection->prepare($statement);
//            if ($preparedStatement == false)
//                throw new DatabaseException("Couldn't prepare statement ${statement}");
//                $result = $preparedStatement->execute($args);
//            if ($result == false)
//                throw new DatabaseException("Couldn't execute statement ${statement}");
//                return $preparedStatement;
//        } catch (\PDOException $exception) {
//            throw new DatabaseException($exception->getMessage());
//        }
//    }
//
//    /**
//     * @param string $tableName
//     * @return array
//     * @throws DatabaseException
//     */
//    public function getTable(string $tableName) : array
//    {
//        if (!$this->currentConnection)
//            throw new DatabaseException("There is no active connection to database");
//        try {
//            $result = $this->statement('SELECT * FROM :table_name', array(':table_name' => $tableName))->fetchAll();
//            return $result;
//        } catch (DatabaseException $exception) {
//            throw new DatabaseException($exception->getMessage() . ". Couldn't get table");
//        }
//    }

}
