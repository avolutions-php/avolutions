<?php

namespace Avolutions\Command;

use ReflectionClass;

abstract class Command
{
    public string $name;

    private array $arguments = [];
    private array $options = [];

    public array $Arguments = [];
    public array $Options = [];

    public function __construct()
    {

    }

    public function getName(): string
    {
        return str_replace('Command', '', (new ReflectionClass($this))->getShortName());
    }

    /**
     * @param Argument $Argument
     */
    public function addArgument(Argument $Argument): void
    {
        // TODO check if correct type?
        $this->Argument[] = $Argument;
    }

    /**
     * @param Option $Option
     */
    public function addOption(Option $Option): void
    {
        // TODO check if correct type?
        $this->Option[] = $Option;
    }

    abstract public function execute();
}