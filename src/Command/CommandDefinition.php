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
 * CommandDefinition class
 *
 * Contains Argument and Option definitions.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CommandDefinition
{
    /**
     * Array of Argument definitions.
     *
     * @var array $Arguments
     */
    private array $Arguments = [];

    /**
     * Array of Option definitions.
     *
     * @var array $Options
     */
    private array $Options = [];

    /**
     * addArgument
     *
     * Adds an Argument definition to the CommandDefinition.
     *
     * @param Argument $Argument An Argument definition.
     */
    public function addArgument(Argument $Argument): void
    {
        $this->Arguments[] = $Argument;
    }

    /**
     * addOption
     *
     * Adds an Option definition to the CommandDefinition.
     *
     * @param Option $Option  An Option definition.
     */
    public function addOption(Option $Option): void
    {
        $this->Options[] = $Option;
    }

    /**
     * getArguments
     *
     * Returns all Argument definitions.
     *
     * @return array Argument definitions.
     */
    public function getArguments(): array
    {
        return $this->Arguments;
    }

    /**
     * getOptions
     *
     * Returns all Option definitions.
     *
     * @return array Option definitions.
     */
    public function getOptions(): array
    {
        return $this->Options;
    }
}