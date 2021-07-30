<?php


namespace Avolutions\Command;


class CommandDefinition
{
    /**
     * @var array
     */
    private array $Arguments = [];

    /**
     * @var array
     */
    private array $Options = [];

    /**
     * @param Argument $Argument
     */
    public function addArgument(Argument $Argument): void
    {
        // TODO allow Argument or array and create Argument if array passed?
        // TODO use name as key?
        $this->Arguments[$Argument->name] = $Argument;
    }

    /**
     * @param Option $Option
     */
    public function addOption(Option $Option): void
    {
        // TODO allow Option or array and create Option if array passed?
        // TODO use name as key?
        $this->Options[$Option->name] = $Option;
    }
}