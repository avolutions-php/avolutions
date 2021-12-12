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
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

/**
 * Logger class
 *
 * The Logger class writes messages with a specific level to a logfile.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.0
 */
class Logger extends AbstractLogger
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
     * @inheritDoc
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        // TODO check for valid loglevel
        if (!in_array($level, $this->loglevels)) {
            throw new InvalidArgumentException(interpolate('Log level \'{0}\' is not valid.', [$level]));
        }

        // only log message if $level is greater or equal than the loglevel from config
        if (array_search($level, $this->loglevels) < array_search($this->minLogLevel, $this->loglevels)) {
            return;
        }

        $message = interpolate($message, $context);

        $datetime = new Datetime();
        $logText = '[' . strtoupper($level) . '] | ' . $datetime->format($this->datetimeFormat) . ' | ' . $message;

        $handle = fopen($this->logfile, 'a');
        fwrite($handle, $logText);
        fwrite($handle, PHP_EOL);
        fclose($handle);
    }
}