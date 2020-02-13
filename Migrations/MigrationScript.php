<?php
$configuration = require '../Kernel/ConfigurationFiles/Migrations.php';
$_SERVER['DOCUMENT_ROOT'] = $configuration['pathToMigrations'];
use Kernel\MigrationHandler\MigrationHandler;
require '../Bootstrap/bootstrap.php';
$migrationHandler = new MigrationHandler($configuration);
$migrationHandler->handle();