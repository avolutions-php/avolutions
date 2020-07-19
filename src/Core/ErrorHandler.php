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

namespace Avolutions\Core;

use ErrorException;
use Avolutions\Logging\Logger;

/**
 * ErrorHandler class
 * 
 * The ErrorHandler class handles uncaught errors and exceptions.
 * 
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.1.2
 */
class ErrorHandler
{	
    /**
	 * handleError
	 * 
	 * Handles uncaught errors, convert them into an exception an throw it.
	 *
	 * @param int $code The level of the error.
	 * @param string $message The error message.
	 * @param string $file The filename the error was raised in.
	 * @param int $line The line number the error was raised at.
	 *
     * @throws \ErrorException
	 */
    public function handleError($code, $message, $file = null, $line = null) 
    {
        throw new ErrorException($message, $code, $code, $file, $line);
    }

    /**
	 * handleException
	 * 
	 * Handles uncaught exceptions and log them with LogLevel 'ERROR'.
	 *
	 * @param \Exception $exception The exception to handle.
	 */
    public function handleException($exception) 
    {
        Logger::error($exception);
    }
}