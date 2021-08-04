<?php
/**
 * TODO
 */
namespace Avolutions\Command;

use Avolutions\Console\Console;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

/**
 * TODO
 */
abstract class Command
{
    /**
     * TODO
     *
     * @var string
     */
    protected static string $name = '';

    /**
     * TODO
     *
     * @var string TODO
     */
    protected static string $description = '';

    /**
     * TODO
     *
     * @var CommandDefinition TODO
     */
    public CommandDefinition $CommandDefinition;

    /**
     * TODO
     *
     * @var Console TODO
     */
    protected Console $Console;

    /**
     * TODO
     *
     * @var array TODO
     */
    private array $arguments = [];

    /**
     * TODO
     *
     * @var array TODO
     */
    private array $options = [];

    /**
     * TODO
     *
     * @param array $argv TODO
     * @param Console $Console TODO
     */
    public function __construct(array $argv, Console $Console)
    {
        $this->Console = $Console;
        $this->CommandDefinition = new CommandDefinition();
        $this->initialize();
        $this->addOptionDefinition(new Option('help', 'h', 'TODO'));
        $this->parseArgv($argv);
    }

    /**
     * TODO
     *
     * @return string TODO
     * @throws ReflectionException TODO
     */
    public static function getName(): string
    {
        return static::$name === '' ? str_replace('Command', '', (new ReflectionClass(get_called_class()))->getShortName()) : static::$name;
    }

    /**
     * TODO
     *
     * @return string TODO
     */
    public static function getDescription(): string
    {
        return static::$description;
    }

    /**
     * TODO
     *
     * @param array $argv TODO
     */
    public function parseArgv(array $argv = [])
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
        }

        $this->parseArguments($arguments);
    }

    /**
     * TODO
     *
     * @param string $name TODO
     * @return mixed TODO
     */
    protected function getOption(string $name): mixed
    {
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }

        return null;
    }

    /**
     * TODO
     *
     * @param string $name TODO
     * @return mixed TODO
     */
    protected function getArgument(string $name): mixed
    {
        if (isset($this->arguments[$name])) {
            return $this->arguments[$name];
        }

        return null;
    }

    /**
     * TODO
     *
     * @param Argument $Argument TODO
     */
    public function addArgumentDefinition(Argument $Argument): void
    {
        // TODO allow Argument or array and create Argument if array passed?
        $this->CommandDefinition->addArgument($Argument);
    }

    /**
     * TODO
     *
     * @param Option $Option TODO
     */
    public function addOptionDefinition(Option $Option): void
    {
        // TODO allow Argument or array and create Argument if array passed?
        $this->CommandDefinition->addOption($Option);
        if ($Option->default !== null) {
            $this->setOption($Option->name, $Option->default);
        }
    }

    /**
     * TODO
     *
     * @return int TODO
     */
    abstract public function execute(): int;

    /**
     * TODO
     */
    abstract public function initialize(): void;

    /**
     * TODO
     *
     * @param array $options TODO
     */
    private function parseOptions(array $options)
    {
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
     * TODO
     *
     * @param array $arguments TODO
     */
    private function parseArguments(array $arguments)
    {
        $ArgumentDefinitions = $this->CommandDefinition->getArguments();

        // TODO throw invalid argument exception if required argument is missing
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
     * TODO
     *
     * @param string $name TODO
     * @param mixed $value TODO
     */
    private function setOption(string $name, mixed $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * TODO
     *
     * @param string $name TODO
     * @param mixed $value TODO
     */
    private function setArgument(string $name, mixed $value)
    {
        $this->arguments[$name] = $value;
    }

    private function showHelp()
    {
        $this->Console->writeLine('Help');
    }
}