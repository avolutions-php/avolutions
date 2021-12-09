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

namespace Avolutions\Command;

/**
 * ExitStatus class
 *
 * Contains constants for Console exit status.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class ExitStatus
{
    /**
     * Default success exit status.
     *
     * @var int SUCCESS
     */
    public const SUCCESS = 0;

    /**
     * Default error exit status.
     *
     * @var int ERROR
     */
    public const ERROR = 1;
}