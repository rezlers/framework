<?php


namespace Kernel\Services;

use Exception;

class Logger
{
    protected static $loggerConfiguration;

    public function __construct($loggerConfiguration = null)
    {
        $this->loggerConfigure($loggerConfiguration);
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

    private function loggerConfigure($loggerConfiguration)
    {
        if (!is_null($loggerConfiguration))
            self::$loggerConfiguration = $loggerConfiguration;
    }

    private function writeLogMessage($level, $message)
    {
        foreach (self::$loggerConfiguration as $key => $value) {
            if (in_array($level, $value['levels']) or $value['levels'][0] == 'all') {
                try {
                    $pathToLogFile = '/var/www/framework/Log/';
                    $logFile = fopen($pathToLogFile . $key, 'a');
                    $dateTime = date('Y-m-d H:i:s');
                    $logMessage = $dateTime . ': ' . $level . ': ' . $message . PHP_EOL;
                    fwrite($logFile, $logMessage);
                    fclose($logFile);
                }
                catch (Exception $exception) {
                    $frameworkLogMessage = 'framework: ' . $exception->getMessage();
                    $this->error($frameworkLogMessage);
                }
            }
        }
    }

}