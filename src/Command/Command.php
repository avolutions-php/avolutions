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
     * @var string TODO
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
     * @param Console|null $Console $Console TODO
     */
    public function __construct(?Console $Console = null)
    {
        $this->Console = $Console ?? new Console();
        $this->CommandDefinition = new CommandDefinition();
        $this->initialize();
        $this->addOptionDefinition(new Option('help', 'h', 'TODO'));

    }


    /**
     * TODO
     *
     * @param array $argv TODO
     * @return int TODO
     */
    public function start(array $argv): int
    {
        if ($this->parseArgv($argv)) {
            return $this->execute();
        }

        return 0;
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
    public function parseArgv(array $argv = []): bool
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
    private function setArgument(string $name, mixed $value): void
    {
        $this->arguments[$name] = $value;
    }

    /**
     * TODO
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
}