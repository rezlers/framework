<?php
$_SERVER['DOCUMENT_ROOT'] = '/var/www/framework/Public';
//var_dump($_SERVER['DOCUMENT_ROOT']);
use Kernel\MigrationHandler\MigrationHandler;
require '../Bootstrap/bootstrap.php';
$migrationHandler = new MigrationHandler();
$migrationHandler->handle();