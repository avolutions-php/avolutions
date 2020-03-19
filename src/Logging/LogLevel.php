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

/**
 * LogLevel class
 *
 * The LogLevel class contains constants which describes the log level.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.1
 */
class LogLevel
{
	/**
	 * @var string EMERGENCY Text for log level emergency
	 */
	const EMERGENCY = 'EMERGENCY';
	
	/**
	 * @var string ALERT Text for log level alert
	 */
	const ALERT = 'ALERT';
	
	/**
	 * @var string CRITICAL Text for log level critical
	 */
	const CRITICAL = 'CRITICAL';

	/**
	 * @var string ERROR Text for log level error
	 */
	const ERROR = 'ERROR';
	
	/**
	 * @var string WARNING Text for log level warning
	 */
	const WARNING = 'WARNING';
	
	/**
	 * @var string NOTICE Text for log level notice
	 */
	const NOTICE = 'NOTICE';
	
	/**
	 * @var string INFO Text for log level info
	 */
	const INFO = 'INFO';
	
	/**
	 * @var string DEBUG Text for log level debug
	 */
	const DEBUG = 'DEBUG';
}