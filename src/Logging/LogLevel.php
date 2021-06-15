<?php
/**
 * AVOLUTIONS
 *
 * Just another open source PHP framework.
 *
 * @copyright   Copyright (c) 2019 - 2021 AVOLUTIONS
 * @license     MIT License (http://avolutions.org/license)
 * @link        http://avolutions.org
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
     * Text for log level emergency
     *
	 * @var string EMERGENCY
	 */
	const EMERGENCY = 'EMERGENCY';

	/**
     * Text for log level alert
     *
	 * @var string ALERT
	 */
	const ALERT = 'ALERT';

	/**
     * Text for log level critical
     *
	 * @var string CRITICAL
	 */
	const CRITICAL = 'CRITICAL';

	/**
     * Text for log level error
     *
	 * @var string ERROR
	 */
	const ERROR = 'ERROR';

	/**
     * Text for log level warning
     *
	 * @var string WARNING
	 */
	const WARNING = 'WARNING';

	/**
     * Text for log level notice
     *
	 * @var string NOTICE
	 */
	const NOTICE = 'NOTICE';

	/**
     * Text for log level info
     *
	 * @var string INFO
	 */
	const INFO = 'INFO';

	/**
     * Text for log level debug
     *
	 * @var string DEBUG
	 */
	const DEBUG = 'DEBUG';
}