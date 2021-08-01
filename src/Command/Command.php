<?php

namespace Avolutions\Command;

use ReflectionClass;

abstract class Command
{
    public string $name;
    public CommandDefinition $CommandDefinition;

    private array $arguments = [];
    private array $options = [];

    public function __construct()
    {
        $this->CommandDefinition = new CommandDefinition();
        $this->initialize();
    }

    public static function getName(): string
    {
        return str_replace('Command', '', (new ReflectionClass(get_called_class()))->getShortName());
    }

    /**
     * @param Argument $Argument
     */
    public function addArgumentDefinition(Argument $Argument): void
    {
        // TODO allow Argument or array and create Argument if array passed?
        $this->CommandDefinition->addArgument($Argument);
    }

    /**
     * @param Option $Option
     */
    public function addOptionDefinition(Option $Option): void
    {
        // TODO allow Argument or array and create Argument if array passed?
        $this->CommandDefinition->addOption($Option);
    }

    // TODO addDefinition method to pass a ArgumentDefinition type?

    abstract public function execute();
    abstract public function initialize();
}