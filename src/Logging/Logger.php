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
 
namespace Avolutions\Logging;

use Avolutions\Config\Config;
use Avolutions\Logging\LogLevel;

/**
 * Logger class
 *
 * The Logger class writes messages with a specific level to a logfile.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.0
 */
class Logger
{	
	/**
	 * log
	 *
	 * Opens the logfile and write the message and all other informations
	 * like date, time, level to the file.
	 *
	 * @param string $logLevel The log level
	 * @param string $message The log message
	 */
    private static function log($logLevel, $message)
    {		
		$logpath = Config::get("logger/logpath");		
		$logfile = Config::get("logger/logfile");	
		$datetimeFormat = Config::get("logger/datetimeFormat");	
						
		$datetime = new \Datetime();
		$logText = "[".$logLevel."] | ".$datetime->format($datetimeFormat)." | ".$message;
										
		if (!is_dir($logpath)){
			mkdir($logpath, 0755);
		}
				
		$handle = fopen($logpath.$logfile, "a");
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
    public static function emergency($message)
    {
		self::log(LogLevel::EMERGENCY, $message);
	}
	
	/**
	 * alert
	 *
	 * Writes the passed message with level "ALERT" to the logfile.
	 * 
	 * @param string $message The message to log
	 */
    public static function alert($message)
    {
		self::log(LogLevel::ALERT, $message);
	}
	
	/**
	 * critical
	 *
	 * Writes the passed message with level "CRITICAL" to the logfile.
	 * 
	 * @param string $message The message to log
	 */
    public static function critical($message)
    {
		self::log(LogLevel::CRITICAL, $message);
	}	
	
	/**
	 * error
	 *
	 * Writes the passed message with level "ERROR" to the logfile.
	 * 
	 * @param string $message The message to log
	 */
    public static function error($message)
    {
		self::log(LogLevel::ERROR, $message);
	}	
	
	/**
	 * warning
	 *
	 * Writes the passed message with level "WARNING" to the logfile.
	 *
	 * @param string $message The message to log
	 */
    public static function warning($message)
    {
		self::log(LogLevel::WARNING, $message);
	}
	
	/**
	 * notice
	 *
	 * Writes the passed message with level "NOTICE" to the logfile.
	 *
	 * @param string $message The message to log
	 */
    public static function notice($message)
    {
		self::log(LogLevel::NOTICE, $message);
	}
	
	/**
	 * info
	 *
	 * Writes the passed message with level "INFO" to the logfile.
	 *
	 * @param string $message The message to log
	 */
    public static function info($message)
    {
		self::log(LogLevel::INFO, $message);
	}	 
	
	/**
	 * debug
	 *
	 * Writes the passed message with level "DEBUG" to the logfile.
	 *
	 * @param string $message The message to log
	 */
    public static function debug($message)
    {
		if (Config::get("logger/debug")) {
			self::log(LogLevel::DEBUG, $message);
		}
	}
}
?>