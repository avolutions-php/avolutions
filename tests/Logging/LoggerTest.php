<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (https://avolutions.org/license)
 * @link        https://avolutions.org
 */

namespace Avolutions\Test\Logging;

use PHPUnit\Framework\TestCase;

use Avolutions\Logging\Logger;
use Avolutions\Logging\LogLevel;

class LoggerTest extends TestCase
{
    private Logger $Logger;

    private string $logPath = __DIR__ . DIRECTORY_SEPARATOR;

    private string $logFile = 'test.log';

    private string $logMessage = 'This is a log message with log level ';

    protected function setUp(): void
    {
        $this->Logger = new Logger($this->logPath, $this->logFile, LogLevel::DEBUG, 'Y-m-d H:i:s.v');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->logPath . $this->logFile)) {
            unlink($this->logPath . $this->logFile);
        }
    }

    public function testLoggerWithLogLevelEmergency()
    {
        $message = $this->logMessage . LogLevel::EMERGENCY;

        $this->Logger->emergency($message);

        $logfileContent = file_get_contents($this->logPath . $this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelAlert()
    {
        $message = $this->logMessage . LogLevel::ALERT;

        $this->Logger->alert($message);

        $logfileContent = file_get_contents($this->logPath . $this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelCritical()
    {
        $message = $this->logMessage . LogLevel::CRITICAL;

        $this->Logger->critical($message);

        $logfileContent = file_get_contents($this->logPath . $this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelError()
    {
        $message = $this->logMessage . LogLevel::ERROR;

        $this->Logger->error($message);

        $logfileContent = file_get_contents($this->logPath . $this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelWarning()
    {
        $message = $this->logMessage . LogLevel::WARNING;

        $this->Logger->warning($message);

        $logfileContent = file_get_contents($this->logPath . $this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelNotice()
    {
        $message = $this->logMessage . LogLevel::NOTICE;

        $this->Logger->notice($message);

        $logfileContent = file_get_contents($this->logPath . $this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelInfo()
    {
        $message = $this->logMessage . LogLevel::INFO;

        $this->Logger->info($message);

        $logfileContent = file_get_contents($this->logPath . $this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }

    public function testLoggerWithLogLevelDebug()
    {
        $message = $this->logMessage . LogLevel::DEBUG;

        $this->Logger->debug($message);

        $logfileContent = file_get_contents($this->logPath . $this->logFile);

        $this->assertStringContainsString($message, $logfileContent);
    }
}