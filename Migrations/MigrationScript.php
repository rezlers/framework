<?php
use Kernel\MigrationHandler\MigrationHandler;
require '../Bootstrap/bootstrap.php';
$migrationHandler = new MigrationHandler();
$migrationHandler->handle();