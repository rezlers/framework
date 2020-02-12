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
            $this->container->getService('Logger')->error('Migrations has failed: ' . $exception->getMessage());
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
        $migrations = $this->getExecutedMigrationsList();
        $localMigrations = $this->getLocalMigrationsList();
        if ($this->isSubArray($migrations, $localMigrations)) {
            $migrationsToExecute = array_diff($localMigrations, $migrations);
            $migrationsToExecute = arsort($this->getSerialNumbers($migrationsToExecute));
            return $migrationsToExecute;
        }
        elseif ($this->isSubArray($localMigrations, $migrations)) {
            throw new MigrationHandlerException("All migrations was executed before");
        }
        throw new MigrationHandlerException("There are not enough migrations in Migrations folder");
    }

    /**
     * @param array $migrationsToExecute
     * @throws MigrationHandlerException
     */
    private function migrate(array $migrationsToExecute)
    {
        foreach ($migrationsToExecute as $key => $value) {
            $migration = $this->getMigration($value);
            $this->executeMigration($migration);
        }
        $this->container->getService('Logger')->info("Migrations " . array_keys($migrationsToExecute) . " has succeed");
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

    private function getLocalMigrationsList()
    {
        $pathToMigrations = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Migrations/';
        return scandir($pathToMigrations);
    }

    private function getExecutedMigrationsList()
    {
        $migrationTable = $this->getTable('Migrations');
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

    private function getTable($tableName)
    {
        $result = $this->connection->statement('SELECT * FROM :table_name', array(':table_name' => $tableName));
        if ($result == false)
            return null;
        return $result->fetchAll();
    }

    /**
     * @param array $migrations
     * @return array
     * @throws MigrationHandlerException
     */
    private function getSerialNumbers(array $migrations)
    {
        $serialNumbers = [];
        foreach ($migrations as $value) {
            $serialNumberStr = array_slice($value, 0, 4);
            foreach ($serialNumberStr as $key => $char) {
                if ($char != '0') {
                    $serialNumber = array_slice($serialNumberStr, $key);
                    $serialNumbers[$value] = intval($serialNumber);
                    break;
                } elseif ($char < '0' and $char > '9') {
                    throw new MigrationHandlerException('Migration filename ' . $value . ' is not valid');
                }
            }
        }
        return $serialNumbers;
    }

    private function getMigration($filename)
    {
        $sqlScriptString = file_get_contents('/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Migrations/' . $filename);
        $sqlScriptString = preg_replace('#\\n#', '', $sqlScriptString);
        $sqlCommands = explode(';', $sqlScriptString);
        $migration = array($filename => $sqlCommands);
        return $migration;
    }

    /**
     * @param array $migration
     * @throws MigrationHandlerException
     */
    private function executeMigration(array $migration)
    {
        $this->container->getService('Logger')->info('Migration ' . array_keys($migration) . ' has started');
        $sqlCommands = array_values($migration);
        foreach ($sqlCommands as $value) {
            $result = $this->connection->statement($value);
            if ($result == false)
                throw new MigrationHandlerException('Command ' . $value . ' has failed');
        }
        $this->container->getService('Logger')->info('Migration ' . array_keys($migration) . ' has succeed');
    }
}