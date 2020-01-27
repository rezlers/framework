<?php
/*
class A
{
    public $var1;
    public $var2;

    public function __construct($var1, $var2)
    {
        $this->var1 = $var1;
        echo $var1;
        $this->var2 = $var2;
        echo $var2;
    }

    public function getVar1()
    {
        return $this->var1;
    }

    public function getVar2()
    {
        return $this->var2;
    }

}
$test = new ReflectionClass('A');
$args = ['2', '1'];
$object = $test->newInstanceArgs($args);
var_dump($object);
*/ ## Reflection API, Ohuenno

require '../Bootstrap/bootstrap.php';


$container = new \Kernel\ServiceContainer();
$container->getService('DB')->connection()->statement('CREATE TABLE test_table (id SERIAL PRIMARY KEY)');
$logger = $container->getService('Logger');
$logger->info('info message');
$logger->notice('notice message');
$logger->critical('critical message');
$logger->alert('alert message');

 ## Container services examples

//$app->handle();

