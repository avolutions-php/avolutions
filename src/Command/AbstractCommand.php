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

use Avolutions\Console\Console;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

/**
 * Command class
 *
 * An abstract class which has to be extended by every Command.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
abstract class AbstractCommand
{
    /**
     * Argument values passed from Command line.
     *
     * @var array
     */
    private array $arguments = [];

    /**
     * Contains Argument and Option definitions.
     *
     * @var CommandDefinition
     */
    public CommandDefinition $CommandDefinition;

    /**
     * Console instance for output.
     *
     * @var Console
     */
    protected Console $Console;

    /**
     * Description/help text for the Command.
     *
     * @var string
     */
    protected static string $description = '';

    /**
     * The name of the Command.
     *
     * @var string
     */
    protected static string $name = '';

    /**
     * Option values passed from Command line.
     *
     * @var array
     */
    private array $options = [];

    /**
     * __construct
     *
     * Creates a new AbstractCommand instance.
     *
     * @param Console|null $Console Console instance for output.
     */
    public function __construct(?Console $Console = null)
    {
        $this->Console = $Console ?? new Console();
        $this->CommandDefinition = new CommandDefinition();

        $this->initialize();
        $this->addOptionDefinition(new Option('help', 'h', 'Display help text for command.'));
    }

    /**
     * addArgumentDefinition
     *
     * Adds an ArgumentDefinition to the CommandDefinition.
     *
     * @param Argument $Argument The Argument definition.
     */
    public function addArgumentDefinition(Argument $Argument): void
    {
        $this->CommandDefinition->addArgument($Argument);
        if ($Argument->default !== null) {
            $this->setArgument($Argument->name, $Argument->default);
        }
    }

    /**
     * addOptionDefinition
     *
     * Adds an Option definition to the Command definition.
     *
     * @param Option $Option The Option definition.
     */
    public function addOptionDefinition(Option $Option): void
    {
        $this->CommandDefinition->addOption($Option);
        if ($Option->default !== null) {
            $this->setOption($Option->name, $Option->default);
        }
    }

    /**
     * execute
     *
     * Contains and executes the command logic.
     *
     * @return int Exit status.
     */
    abstract public function execute(): int;

    /**
     * getArgument
     *
     * Returns the value of an Argument or null if it not exists.
     *
     * @param string $name The name of the Argument.
     *
     * @return mixed The value of the Argument.
     */
    protected function getArgument(string $name): mixed
    {
        if (isset($this->arguments[$name])) {
            return $this->arguments[$name];
        }

        return null;
    }

    /**
     * getDescription
     *
     * Returns the description of the Command.
     *
     * @return string Command description.
     */
    public static function getDescription(): string
    {
        return static::$description;
    }

    /**
     * getName
     *
     * Returns the name of the Command.
     *
     * @return string Command name.
     *
     * @throws ReflectionException
     */
    public static function getName(): string
    {
        return static::$name === '' ? str_replace('Command', '', (new ReflectionClass(get_called_class()))->getShortName()) : static::$name;
    }

    /**
     * getOption
     *
     * Returns the value of an Option or null if it not exists.
     *
     * @param string $name The name of the Option.
     *
     * @return mixed The value of the Option.
     */
    protected function getOption(string $name): mixed
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }

        return null;
    }

    /**
     * initialize
     *
     * Is called before the execution to initialize the Argument and Option definition of the Command.
     */
    abstract public function initialize(): void;

    /**
     * parseArguments
     *
     * Parses and sets the Argument input values from command line.
     *
     * @param array $arguments  An array containing Argument input.
     */
    private function parseArguments(array $arguments)
    {
        $this->arguments = [];
        $ArgumentDefinitions = $this->CommandDefinition->getArguments();

        foreach ($ArgumentDefinitions as $key => $ArgumentDefinition) {
            if(!isset($arguments[$key])) {
                if (!$ArgumentDefinition->optional) {
                    throw new InvalidArgumentException('Argument ' . $ArgumentDefinition->name . ' is required.');
                }
            } else {
                $this->setArgument($ArgumentDefinition->name, $arguments[$key]);
            }
        }
    }

    /**
     * parseArgv
     *
     * Parses and sets the Argument and Option input values from command line.
     *
     * @param array $argv An array containing Argument and Option input.
     */
    private function parseArgv(array $argv = []): bool
    {
        $arguments = [];
        $options = [];

        array_filter($argv, function ($value) use (&$arguments, &$options) {
            if (str_starts_with($value, '-') || str_starts_with($value, '--')) {
                // all values starting with - or -- are options
                $options[] = $value;
            } else {
                // all other values are arguments
                $arguments[] = $value;
            }
        });

        $this->parseOptions($options);
        if($this->getOption('help')) {
            $this->showHelp();
            return false;
        }

        $this->parseArguments($arguments);

        return true;
    }

    /**
     * parseOptions
     *
     * Parses and sets the Option input values from command line.
     *
     * @param array $options An array containing Option input.
     */
    private function parseOptions(array $options)
    {
        $this->options = [];
        $OptionDefinitions = $this->CommandDefinition->getOptions();

        foreach ($OptionDefinitions as $OptionDefinition) {
            if (
                in_array('--' . $OptionDefinition->name, $options)
                || in_array('-' . $OptionDefinition->short, $options)
            ) {
                $this->setOption($OptionDefinition->name, true);
            }
        }
    }

    /**
     * setOption
     *
     * Sets the value for an Option.
     *
     * @param string $name Name of the Option.
     * @param mixed $value Value of the Option.
     */
    private function setOption(string $name, mixed $value): void
    {
        $this->options[$name] = $value;
    }

    /**
     * setArgument
     *
     * Sets the value for an Argument.
     *
     * @param string $name Name of the Argument.
     * @param mixed $value Value of the Argument.
     */
    private function setArgument(string $name, mixed $value): void
    {
        $this->arguments[$name] = $value;
    }

    /**
     * showHelp
     *
     * Displays the help text for the Command, including usage and details about Arguments and Options depending
     * on the CommandDefinition.
     */
    private function showHelp(): void
    {
        $ArgumentDefinitions = $this->CommandDefinition->getArguments();
        $OptionDefinitions = $this->CommandDefinition->getOptions();

        $this->Console->writeLine(self::getDescription());
        $this->Console->writeLine('');
        $this->Console->writeLine('Usage:', ['color' => 'green']);
        $this->Console->write('  ' . self::getName());
        foreach ($ArgumentDefinitions as $ArgumentDefinition) {
            if ($ArgumentDefinition->optional) {
                $this->Console->write(' [<' . $ArgumentDefinition->name . '>]');
            } else {
                $this->Console->write(' <' . $ArgumentDefinition->name . '>');
            }
        }
        $this->Console->writeLine(' [options]');
        $this->Console->writeLine('');

        if (count($ArgumentDefinitions) > 0) {
            $longestArgumentName = max(array_map('strlen', array_map(function($ArgumentDefinition) {
                return $ArgumentDefinition->name;
            }, $ArgumentDefinitions)));

            $this->Console->writeLine('Arguments:', ['color' => 'green']);
            foreach ($ArgumentDefinitions as $ArgumentDefinition) {
                $this->Console->write('  ' . str_pad($ArgumentDefinition->name, $longestArgumentName) . "\t");
                if ($ArgumentDefinition->optional) {
                    $this->Console->write('(Optional) ');
                }
                $this->Console->writeLine($ArgumentDefinition->help);
            }
            $this->Console->writeLine('');
        }
        $this->Console->writeLine('Options:', ['color' => 'green']);
        if (count($OptionDefinitions) > 0) {
            $longestOptionName = max(array_map('strlen', array_map(function ($OptionDefinition) {
                return $OptionDefinition->short . $OptionDefinition->name;
            }, $OptionDefinitions)));
            foreach ($OptionDefinitions as $OptionDefinition) {
                if ($OptionDefinition->short != '') {
                    $optionShortAndName = '  -' . $OptionDefinition->short . ', ';
                } else {
                    $optionShortAndName = str_pad('', 6);
                }
                $optionShortAndName .= '--' . $OptionDefinition->name;

                $this->Console->writeLine(str_pad($optionShortAndName, $longestOptionName + 7) . "\t" . $OptionDefinition->help);
            }
        }
    }

    /**
     * start
     *
     * Parse Argument and Option inputs and executes the Command.
     *
     * @param array $argv An array containing Argument and Option input.
     *
     * @return int Exit status.
     */
    public function start(array $argv): int
    {
        if ($this->parseArgv($argv)) {
            return $this->execute();
        }

        return ExitStatus::SUCCESS;
    }
}