<?php

require '../Bootstrap/bootstrap.php';

$app->handle();

/*
function test($var)
{
    echo $var;
}
$callable1 = 'test';
call_user_func_array($callable1, array(1));

$callable2 = function ($var) {
    echo $var;
};
call_user_func_array($callable2, array(2));

class A
{
    public function method($var)
    {
        echo $var;
    }
}
$callable3 = array(new A(), 'method');
call_user_func_array($callable3, array(3));
/* ## callable example
/*class A
{
    public function handle()
    {

    }
}

$var = new A();
$method = $var->handle;*/ ## That is an answer why do we need array that we can invoke
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
/*
class A
{
    protected static $testArray;

    public function passValue(&$array)
    {
        self::$testArray = $array;
    }
}

$testArray = ['1', '2'];

$testObject = new A();

$testObject->passValue($testArray);

$otherTestObject = new A();

die;
*/ ## pass array by reference
/*
$container = new \Kernel\ServiceContainer();
$container->getService('DB')->connection()->statement('CREATE TABLE test_table (id SERIAL PRIMARY KEY)');
$logger = $container->getService('MyLogger');
$logger->info('info message');
$logger->notice('notice message');
$logger->critical('critical message');
$logger->alert('alert message');
*/ ## Container services examples
/*
$container = new \Kernel\ServiceContainer();
$mailer = $container->getService('PhpMailerWrapper');
$email = 'rezlers123@gmail.com';
$subject = 'Test Message';
$msg = "<div>Hello! Here is your link</div>";
$mailer->mail($email, $subject, $msg);
*/ ## PhpMailerWrapper from container example
/*
$container = new \Kernel\ServiceContainer();
$mailer = $container->getService('MailerInterface');
$logger = $container->getService('LoggerInterface');
$database = $container->getService('DatabaseInterface');
$controller = $container->getService('CallableHandler');
$middleware = $container->getService('MiddlewareHandler');
$router = $container->getService('Router');
*/ ## For service testing