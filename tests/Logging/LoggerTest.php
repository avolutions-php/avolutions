<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @copyright	Copyright (c) 2019 - 2020 AVOLUTIONS
 * @license		MIT License (http://avolutions.org/license)
 * @link		http://avolutions.org
 */

use PHPUnit\Framework\TestCase;

use Avolutions\Config\Config;
use Avolutions\Logging\Logger;
use Avolutions\Logging\LogLevel;

class LoggerTest extends TestCase
{
    private $logFile = '';
    private $logMessage = 'This is a log message with log level ';

    protected function setUp(): void
    {
        $this->logFile = Config::get("logger/logpath").Config::get("logger/logfile");
    }

    public function testLoggerWithLogLevelEmergency()
    {
        $message = $this->logMessage.LogLevel::EMERGENCY;

        Logger::emergency($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelAlert()
    {
        $message = $this->logMessage.LogLevel::ALERT;

        Logger::alert($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelCritical()
    {
        $message = $this->logMessage.LogLevel::CRITICAL;

        Logger::critical($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelError()
    {
        $message = $this->logMessage.LogLevel::ERROR;

        Logger::error($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelWarning()
    {
        $message = $this->logMessage.LogLevel::WARNING;

        Logger::warning($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelNotice()
    {
        $message = $this->logMessage.LogLevel::NOTICE;

        Logger::notice($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelInfo()
    {
        $message = $this->logMessage.LogLevel::INFO;

        Logger::info($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelDebug()
    {
        $message = $this->logMessage.LogLevel::DEBUG;

        Logger::debug($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }
}