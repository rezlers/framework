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

}