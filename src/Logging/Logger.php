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

namespace Avolutions\Logging;

use Datetime;
use Psr\Log\LogLevel;

/**
 * Logger class
 *
 * The Logger class writes messages with a specific level to a logfile.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class Logger
{
    /**
     * The loglevels in ascending order of priority.
     *
     * @var array $loglevels
     */
    private array $loglevels = [
        LogLevel::DEBUG,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::CRITICAL,
        LogLevel::ALERT,
        LogLevel::EMERGENCY
    ];

    /**
     * Path to store logfiles.
     *
     * @var string $logpath
     */
    private string $logpath;

    /**
     * Name of the logfile.
     *
     * @var string $logfile
     */
    private string $logfile;

    /**
     * Format of the log timestamp.
     *
     * @var string $datetimeFormat
     */
    private string $datetimeFormat;

    /**
     * Only messages with same or higher level are logged.
     *
     * @var string $minLogLevel
     */
    private string $minLogLevel;

    /**
     * __construct
     *
     * Creates and initializes a new Logger instance.
     *
     * @param string $logpath Path to store logfiles.
     * @param string $logfile Name of the logfile.
     * @param string $minLogLevel Format of the log timestamp
     * @param string $datetimeFormat Only messages with same or higher level are logged.
     */
    public function __construct(string $logpath, string $logfile, string $minLogLevel, string $datetimeFormat)
    {
        $this->logpath = $logpath;
        $this->logfile = $logpath . $logfile;
        $this->minLogLevel = $minLogLevel;
        $this->datetimeFormat = $datetimeFormat;

        if (!is_dir($this->logpath)) {
            mkdir($this->logpath, 0755);
        }
    }

    /**
     * log
     *
     * Opens the logfile and write the message and all other information
     * like date, time, level to the file.
     *
     * @param string $logLevel The log level
     * @param string $message The log message
     */
    private function log(string $logLevel, string $message)
    {
        // only log message if $loglevel is greater or equal than the loglevel from config
        if (array_search($logLevel, $this->loglevels) < array_search($this->minLogLevel, $this->loglevels)) {
            return;
        }

        $datetime = new Datetime();
        $logText = '[' . $logLevel . '] | ' . $datetime->format($this->datetimeFormat) . ' | ' . $message;

        $handle = fopen($this->logfile, 'a');
        fwrite($handle, $logText);
        fwrite($handle, PHP_EOL);
        fclose($handle);
    }

    /**
     * emergency
     *
     * Writes the passed message with level "EMERGENCY" to the logfile.
     *
     * @param string $message The message to log
     */
    public function emergency(string $message)
    {
        $this->log(LogLevel::EMERGENCY, $message);
    }

    /**
     * alert
     *
     * Writes the passed message with level "ALERT" to the logfile.
     *
     * @param string $message The message to log
     */
    public function alert(string $message)
    {
        $this->log(LogLevel::ALERT, $message);
    }

    /**
     * critical
     *
     * Writes the passed message with level "CRITICAL" to the logfile.
     *
     * @param string $message The message to log
     */
    public function critical(string $message)
    {
        $this->log(LogLevel::CRITICAL, $message);
    }

    /**
     * error
     *
     * Writes the passed message with level "ERROR" to the logfile.
     *
     * @param string $message The message to log
     */
    public function error(string $message)
    {
        $this->log(LogLevel::ERROR, $message);
    }

    /**
     * warning
     *
     * Writes the passed message with level "WARNING" to the logfile.
     *
     * @param string $message The message to log
     */
    public function warning(string $message)
    {
        $this->log(LogLevel::WARNING, $message);
    }

    /**
     * notice
     *
     * Writes the passed message with level "NOTICE" to the logfile.
     *
     * @param string $message The message to log
     */
    public function notice(string $message)
    {
        $this->log(LogLevel::NOTICE, $message);
    }

    /**
     * info
     *
     * Writes the passed message with level "INFO" to the logfile.
     *
     * @param string $message The message to log
     */
    public function info(string $message)
    {
        $this->log(LogLevel::INFO, $message);
    }

    /**
     * debug
     *
     * Writes the passed message with level "DEBUG" to the logfile.
     *
     * @param string $message The message to log
     */
    public function debug(string $message)
    {
        $this->log(LogLevel::DEBUG, $message);
    }
}