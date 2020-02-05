<?php


namespace Kernel\Services\Implementations;

use Exception;
use Kernel\Services\Logger;

class MyLogger implements Logger
{
    protected static $configuration;

    public function __construct($configuration)
    {
        $this->loggerConfigure($configuration);
    }

    public function emergency($message)
    {
        $this->writeLogMessage('emergency', $message);
    }

    public function alert($message)
    {
        $this->writeLogMessage('alert', $message);
    }

    public function error($message)
    {
        $this->writeLogMessage('error', $message);
    }

    public function warning($message)
    {
        $this->writeLogMessage('warning', $message);
    }

    public function notice($message)
    {
        $this->writeLogMessage('notice', $message);
    }

    public function info($message)
    {
        $this->writeLogMessage('info', $message);
    }

    public function critical($message)
    {
        $this->writeLogMessage('critical', $message);
    }

    public function frameworkLog($message)
    {
        $this->writeLogMessage('critical', $message);
    }

    private function loggerConfigure($configuration)
    {
        if (!self::$configuration)
            self::$configuration = $configuration;
    }

    private function writeLogMessage($level, $message)
    {
        $pathToLogFile = self::$configuration['pathToLogFile'];
        $logFile = fopen($pathToLogFile . self::$configuration['name'], 'a');
        chmod($pathToLogFile . self::$configuration['name'], 0777);
        $dateTime = date('Y-m-d H:i:s');
        $logMessage = $dateTime . ': ' . $level . ': ' . $message . PHP_EOL;
        fwrite($logFile, $logMessage);
        fclose($logFile);
    }


}