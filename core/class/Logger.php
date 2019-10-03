<?php
/**
 * AVOLUTIONS
 * 
 * Just another open source PHP framework.
 * 
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 * @copyright	2019 avolutions (http://avolutions.de)
 * @license		MIT License (https://opensource.org/licenses/MIT)
 * @link		https://github.com/avolutions/avolutions
 */
 
namespace core;

use core\Config;

/**
 * Logger class
 *
 * The Logger class writes messages with a specific level to a logfile.
 *
 * @package		core
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class Logger
{
	/**
	 * @var string $emergency Text for log level emergency
	 */
	private static $emergency = "EMERGENCY";
	
	/**
	 * @var string $alert Text for log level alert
	 */
	private static $alert = "ALERT";
	
	/**
	 * @var string $critical Text for log level critical
	 */
	private static $critical = "CRITICAL";

	/**
	 * @var string $error Text for log level error
	 */
	private static $error = "ERROR";
	
	/**
	 * @var string $warning Text for log level warning
	 */
	private static $warning = "WARNING";
	
	/**
	 * @var string $notice Text for log level notice
	 */
	private static $notice = "NOTICE";
	
	/**
	 * @var string $info Text for log level info
	 */
	private static $info = "INFO";
	
	/**
	 * @var string $debug Text for log level debug
	 */
	private static $debug = "DEBUG";
	
	
	/**
	 * log
	 *
	 * Opens the logfile and write the message and all other informations
	 * like date, time, level to the file.
	 *
	 * @param string $logLevel The log level
	 * @param string $message The log message
	 */
	private static function log($logLevel, $message) {		
		$logpath = Config::get("logger/logpath");		
		$logfile = Config::get("logger/logfile");	
		$datetimeFormat = Config::get("logger/datetimeFormat");	
						
		$datetime = new \Datetime();
		$logText = "[".$logLevel."] | ".$datetime->format($datetimeFormat)." | ".$message;
										
		if(!is_dir($logpath)){
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
	public static function emergency($message) {
		self::log(self::$emergency, $message);
	}
	
	/**
	 * alert
	 *
	 * Writes the passed message with level "ALERT" to the logfile.
	 * 
	 * @param string $message The message to log
	 */
	public static function alert($message) {
		self::log(self::$alert, $message);
	}
	
	/**
	 * critical
	 *
	 * Writes the passed message with level "CRITICAL" to the logfile.
	 * 
	 * @param string $message The message to log
	 */
	public static function critical($message) {
		self::log(self::$critical, $message);
	}	
	
	/**
	 * error
	 *
	 * Writes the passed message with level "ERROR" to the logfile.
	 * 
	 * @param string $message The message to log
	 */
	public static function error($message) {
		self::log(self::$error, $message);
	}	
	
	/**
	 * warning
	 *
	 * Writes the passed message with level "WARNING" to the logfile.
	 *
	 * @param string $message The message to log
	 */
	public static function warning($message) {
		self::log(self::$warning, $message);
	}
	
	/**
	 * notice
	 *
	 * Writes the passed message with level "NOTICE" to the logfile.
	 *
	 * @param string $message The message to log
	 */
	public static function notice($message) {
		self::log(self::$notice, $message);
	}
	
	/**
	 * info
	 *
	 * Writes the passed message with level "INFO" to the logfile.
	 *
	 * @param string $message The message to log
	 */
	public static function info($message) {
		self::log(self::$info, $message);
	}	 
	
	/**
	 * debug
	 *
	 * Writes the passed message with level "DEBUG" to the logfile.
	 *
	 * @param string $message The message to log
	 */
	public static function debug($message) {
		if(Config::get("logger/debug")) {
			self::log(self::$debug, $message);
		}
	}
}
?>