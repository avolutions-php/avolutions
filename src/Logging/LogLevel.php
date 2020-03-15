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
 
namespace Avolutions\Logging;

/**
 * LogLevel class
 *
 * The LogLevel class contains constants which describes the log levelsl
 *
 * @package		Logging
 * @author		Alexander Vogt <alexander.vogt@avolutions.de>
 */
class LogLevel
{
	/**
	 * @var string $emergency Text for log level emergency
	 */
	const EMERGENCY = "EMERGENCY";
	
	/**
	 * @var string $alert Text for log level alert
	 */
	const ALERT = "ALERT";
	
	/**
	 * @var string $critical Text for log level critical
	 */
	const CRITICAL = "CRITICAL";

	/**
	 * @var string $error Text for log level error
	 */
	const ERROR = "ERROR";
	
	/**
	 * @var string $warning Text for log level warning
	 */
	const WARNING = "WARNING";
	
	/**
	 * @var string $notice Text for log level notice
	 */
	const NOTICE = "NOTICE";
	
	/**
	 * @var string $info Text for log level info
	 */
	const INFO = "INFO";
	
	/**
	 * @var string $debug Text for log level debug
	 */
	const DEBUG = "DEBUG";
}
?>