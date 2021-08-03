<?php

namespace Avolutions\Command;

use Avolutions\Console\Console;
use ReflectionClass;

abstract class Command
{
    protected static string $name = '';
    protected static string $description = '';
    public CommandDefinition $CommandDefinition;
    protected Console $Console;

    private array $arguments = [];
    private array $options = [];

    public function __construct(Console $Console)
    {
        $this->Console = $Console;
        $this->CommandDefinition = new CommandDefinition();
        $this->initialize();
    }

    public static function getName(): string
    {
        return static::$name === '' ? str_replace('Command', '', (new ReflectionClass(get_called_class()))->getShortName()) : static::$name;
    }

    public static function getDescription(): string
    {
        return static::$description;
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

    abstract public function execute(): int;
    abstract public function initialize();
}