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

namespace Avolutions\Core;

use ErrorException;
use Avolutions\Logging\Logger;
use Throwable;

/**
 * ErrorHandler class
 *
 * The ErrorHandler class handles uncaught errors and exceptions.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.1.2
 */
class ErrorHandler
{
    /**
     * Logger instance.
     *
     * @var Logger $Logger
     */
    private Logger $Logger;

    /**
     * __construct
     *
     * Createas a new ErrorHandler instance.
     *
     * @param Logger $Logger Logger instance
     */
    public function __construct(Logger $Logger)
    {
        $this->Logger = $Logger;
    }

    /**
     * handleError
     *
     * Handles uncaught errors, convert them into an exception an throw it.
     *
     * @param int $code The level of the error.
     * @param string $message The error message.
     * @param string|null $file The filename the error was raised in.
     * @param int|null $line The line number the error was raised at.
     *
     * @throws ErrorException
     */
    public function handleError(int $code, string $message, ?string $file = null, ?int $line = null)
    {
        throw new ErrorException($message, $code, $code, $file, $line);
    }

    /**
     * handleException
     *
     * Handles uncaught exceptions and log them with LogLevel 'ERROR'.
     *
     * @param Throwable $exception The exception to handle.
     *
     * @throws Throwable
     */
    public function handleException(Throwable $exception)
    {
        $this->Logger->error($exception);

        throw $exception;
    }
}