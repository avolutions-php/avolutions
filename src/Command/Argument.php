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
 * Argument class
 *
 * Contains the definition of a Command Argument.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class Argument
{
    /**
     * Help text for the Argument.
     *
     * @var string|mixed
     */
    public string $help;

    /**
     * Name of the Argument.
     *
     * @var string
     */
    public string $name;

    /**
     * Indicates if Argument is optional (true) or not (false).
     *
     * @var bool|mixed
     */
    public bool $optional;

    /**
     * __construct
     *
     * Creates a new Argument definition.
     *
     * @param string $name Name of the Argument.
     * @param string $help Help text for the Argument.
     * @param bool $optional Indicates if Argument is optional (true) or not (false).
     */
    public function __construct(string $name, string $help = '', bool $optional = false)
    {
        $this->name = $name;
        $this->help = $help;
        $this->optional = $optional;
    }
}