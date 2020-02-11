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
            $this->sync();
            $this->migrate();
        } catch (MigrationHandlerException $exception) {

        }
    }

    private function connect()
    {
        $this->connection = $this->container->getService('Database')->connection();
    }

    private function sync()
    {
        $migrationTable = $this->connection->getTable('Migrations');
        $migrations = array();
        foreach ($migrationTable as $value) {
            $migrations[] = $value[1];
        }
        if (is_null($migrationTable)){
            $this->connection->statement("CREATE TABLE migrations (datetime TIMESTAMP, migration_name VARCHAR(255))");
        }
        $pathToMigrations = '/' . trim($_SERVER['DOCUMENT_ROOT'], '/') . '/../Migrations/';
        $localMigrations = scandir($pathToMigrations);
    }

    private function migrate()
    {

    }

    private function configureContainer()
    {
        $this->container = new ServiceContainer();
    }

    private function getLocalMigrations()
    {

    }

    private function getExecutedMigrations()
    {

    }

    private function inArray($subArray, $array)
    {
        
    }

}