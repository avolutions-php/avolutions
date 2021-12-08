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

/**
 * LogLevel class
 *
 * The LogLevel class contains constants which describes the log level.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.1
 */
class LogLevel
{
    /**
     * Text for log level emergency
     *
     * @var string EMERGENCY
     */
    public const EMERGENCY = 'EMERGENCY';

    /**
     * Text for log level alert
     *
     * @var string ALERT
     */
    public const ALERT = 'ALERT';

    /**
     * Text for log level critical
     *
     * @var string CRITICAL
     */
    public const CRITICAL = 'CRITICAL';

    /**
     * Text for log level error
     *
     * @var string ERROR
     */
    public const ERROR = 'ERROR';

    /**
     * Text for log level warning
     *
     * @var string WARNING
     */
    public const WARNING = 'WARNING';

    /**
     * Text for log level notice
     *
     * @var string NOTICE
     */
    public const NOTICE = 'NOTICE';

    /**
     * Text for log level info
     *
     * @var string INFO
     */
    public const INFO = 'INFO';

    /**
     * Text for log level debug
     *
     * @var string DEBUG
     */
    public const DEBUG = 'DEBUG';
}