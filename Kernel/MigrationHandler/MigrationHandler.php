<?php


namespace Kernel\MigrationHandler;

use Kernel\Container\ServiceContainer;
use Kernel\Container\Services\DatabaseInterface;
use Kernel\Exceptions\DatabaseException;
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
    /**
     * @var int
     */
    private $numerationLength;

    public function __construct($configuration)
    {
        $this->configureNumerationLength($configuration);
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
            var_dump($exception->getMessage());
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
    private function sync(): array
    {
        $ExecutedMigrationsList = $this->getExecutedMigrationsList();
        $localMigrationsList = $this->getLocalMigrationsList();
        if ($this->isSubArray($ExecutedMigrationsList, $localMigrationsList)) {
            $migrationsToExecute = array_diff($localMigrationsList, $ExecutedMigrationsList);
            $migrationsToExecute = $this->getSerialNumbers($migrationsToExecute);
            arsort($migrationsToExecute);
            return array_reverse($migrationsToExecute);
        } elseif ($this->isSubArray($localMigrationsList, $ExecutedMigrationsList)) {
            throw new MigrationHandlerException("There are not enough migrations in Migrations folder");
        }
        throw new MigrationHandlerException("All migrations were executed before. If you want to execute them again then you should delete data from migrations table in database");
    }

    /**
     * @param array $migrationsToExecute
     * @throws MigrationHandlerException
     */
    private function migrate(array $migrationsToExecute)
    {
        foreach ($migrationsToExecute as $key => $value) {
            $migration = $this->getMigration($key);
            $this->executeMigration($migration);
        }
        $this->container->getService('Logger')->info("Migrations " . implode(', ',array_keys($migrationsToExecute)) . " has succeed");
    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

    private function getLocalMigrationsList()
    {
        $pathToMigrations = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Migrations/';
        $filesFromFolder = scandir($pathToMigrations);
        $localMigrationsList = [];
        foreach ($filesFromFolder as $value) {
            $counter = 0;
            while ($counter <= $this->numerationLength - 1) {
                if (!($value[$counter] >= '0' and $value[$counter] <= '9'))
                    break;
                $counter += 1;
            }
            if ($counter == $this->numerationLength)
                $localMigrationsList[] = $value;
        }
        return $localMigrationsList;
    }

    /**
     * @return array
     * @throws MigrationHandlerException
     */
    private function getExecutedMigrationsList()
    {
        $migrationTable = $this->getTable('migrations');
        $migrationsList = [];
        foreach ($migrationTable as $value) {
            $migrationsList[] = $value[1];
        }

        return $migrationsList;
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

    /**
     * @param $tableName
     * @return mixed
     * @throws MigrationHandlerException
     */
    private function getTable($tableName)
    {
        $result = $this->connection->statement('SELECT * FROM migrations');
//        if ($result === false)
//            throw new MigrationHandlerException("Couldn't select migrations table");
        if ($result === false) {
            $result = $this->connection->statement("CREATE TABLE migrations (datetime TIMESTAMP, migration_name VARCHAR(255))");
            if ($result == false)
                throw new MigrationHandlerException("Couldn't create migrations table");
        }
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
            $serialNumberStr = substr($value, 0, $this->numerationLength);
            $serialNumberArr = str_split($serialNumberStr);
            foreach ($serialNumberArr as $key => $char) {
                if ($char != '0') {
                    $serialNumber = substr($serialNumberStr, $key);
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
        foreach ($sqlCommands as $key => $value) {
            if ($value == '')
                array_splice($sqlCommands, $key, 1);
        }
        if (empty($sqlCommands))
            $sqlCommands = [];

        $migration = array($filename => $sqlCommands);
        return $migration;
    }

    /**
     * @param array $migration
     * @throws MigrationHandlerException
     */
    private function executeMigration(array $migration)
    {
        $this->container->getService('Logger')->info('Migration ' . implode(', ', array_keys($migration)) . ' has started');
        $sqlCommands = array_values($migration);
        $sqlCommands = $sqlCommands[0];
        foreach ($sqlCommands as $value) {
            $result = $this->connection->statement($value);
            if ($result == false)
                throw new MigrationHandlerException("Something has gone wrong with statement " . $value);
        }
        $this->connection->statement('INSERT INTO migrations VALUES (NOW(), ?)', [array_keys($migration)[0]]);
        $this->container->getService('Logger')->info('Migration ' . implode(', ', array_keys($migration)) . ' has succeed');
    }

    private function configureNumerationLength($configuration)
    {
        $this->numerationLength = $configuration['NumerationLength'];
    }
}
