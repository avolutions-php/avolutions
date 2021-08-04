<?php
/**
 * TODO
 */

namespace Avolutions\Command;

/**
 * TODO
 */
class CommandDefinition
{
    /**
     * TODO
     *
     * @var array
     */
    private array $Arguments = [];

    /**
     * TODO
     *
     * @var array
     */
    private array $Options = [];

    /**
     * TODO
     *
     * @param Argument $Argument TODO
     */
    public function addArgument(Argument $Argument): void
    {
        // TODO allow Argument or array and create Argument if array passed?
        // TODO use name as key?
        $this->Arguments[] = $Argument;
    }

    /**
     * TODO
     *
     * @param Option $Option TODO
     */
    public function addOption(Option $Option): void
    {
        // TODO allow Option or array and create Option if array passed?
        // TODO use name as key?
        $this->Options[] = $Option;
    }

    /**
     * TODO
     *
     * @return array TODO
     */
    public function getOptions(): array
    {
        return $this->Options;
    }

    /**
     * TODO
     *
     * @return array TODO
     */
    public function getArguments(): array
    {
        return $this->Arguments;
    }
}