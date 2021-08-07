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
 * Option class
 *
 * Contains the definition of a Command Option.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class Option
{
    /**
     * Default value of the Option.
     *
     * @var mixed|null
     */
    public mixed $default;

    /**
     * Help text for the Option.
     *
     * @var string|mixed
     */
    public string $help;

    /**
     * Name of the Option.
     *
     * @var string
     */
    public string $name;

    /**
     * Short name of the Option.
     *
     * @var string|mixed
     */
    public string $short;

    /**
     * __construct
     *
     * Creates a new Option definition.
     *
     * @param string $name Name of the Option.
     * @param string $short Short name of the Option.
     * @param string $help Help text for the Argument.
     * @param bool $default Default value of the Option.
     */
    public function __construct(string $name, string $short = '', string $help = '', bool $default = false)
    {
        $this->name = $name;
        $this->short = $short;
        $this->help = $help;
        $this->default = $default;
    }
}