<?php


namespace Kernel\MigrationHandler;

use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\DatabaseInterface;
use Kernel\Exceptions\MigrationHandlerException;

class MigrationHandler
{

    /**
     * @var DatabaseInterface
     */
    private $connection;

    /**
     * @var ServiceContainer
     */
    private $container;

    public function __construct()
    {
        $this->configureContainer();
    }

    public function handle()
    {
        try {
            $this->connect();
            $migrationsToExecute = $this->sync();
            $this->migrate($migrationsToExecute);
        } catch (MigrationHandlerException $exception) {
            // Rollback
        }
    }

    private function connect()
    {
        $this->connection = $this->container->getService('Database')->connection();
    }

    /**
     * @throws MigrationHandlerException
     */
    private function sync() : array
    {
        $migrations = $this->getExecutedMigrations();
        $localMigrations = $this->getLocalMigrations();
        if ($this->isSubArray($migrations, $localMigrations)) {
            $migrationsToExecute = array_diff($localMigrations, $migrations);
            return $migrationsToExecute;
        }
        elseif ($this->isSubArray($localMigrations, $migrations)) {
            throw new MigrationHandlerException("All migrations was executed before");
        }
        throw new MigrationHandlerException("There are not enough migrations");
    }

    /**
     * @param array $migrationsToExecute
     * @throws MigrationHandlerException
     */
    private function migrate(array $migrationsToExecute)
    {
        foreach ($migrationsToExecute as $value) {
            $sqlScriptString = file_get_contents('/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Migrations/' . $value);
            $result = $this->connection->statement($sqlScriptString);
            if ($result == false) {
                throw new MigrationHandlerException("Migration ${value} has failed");
            }
            $this->container->getService('Logger')->error("Migration ${value} has succeed");
        }
        $this->container->getService('Logger')->error("Migrations ${migrationsToExecute} has succeed");
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

    private function getLocalMigrations()
    {
        $pathToMigrations = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Migrations/';
        return scandir($pathToMigrations);
    }

    private function getExecutedMigrations()
    {
        $migrationTable = $this->connection->getTable('Migrations');
        if (is_null($migrationTable)) {
            $this->connection->statement("CREATE TABLE migrations (datetime TIMESTAMP, migration_name VARCHAR(255))");
        }
        $migrations = array();
        foreach ($migrationTable as $value) {
            $migrations[] = $value[1];
        }

        return $migrations;
    }

    private function isSubArray(array $subArray, array $array): bool
    {
        foreach ($subArray as $value) {
            if (!in_array($value, $array))
                return false;
        }

        if (count($subArray) != count($array))
            return true;
        return false;
    }

}