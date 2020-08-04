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
        // empty logfile     
        $this->logFile = Config::get("logger/logpath").Config::get("logger/logfile");
        file_put_contents($this->logFile, '');
    }

    public function testLoggerWithLogLevelEmergency()
    {
        $message = $this->logMessage.LogLevel::EMERGENCY;

        Logger::emergency($message);

        $logfileContent = file_get_contents($this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }
}