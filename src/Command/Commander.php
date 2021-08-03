<?php


namespace Avolutions\Command;


use Avolutions\Console\Console;

class Commander
{
    /**
     *
     */

    /**
     * TODO
     */
    private Console $Console;

    /**
     * TODO
     *
     * @var array
     */
    private array $argv = [];

    /**
     * Commander constructor.
     *
     * TODO
     */
    public function __construct(array $argv)
    {
        $this->argv = $argv;
        $this->Console = new Console();
    }

    /**
     * TODO
     */
    public function start(): int
    {
        $options = [];
        $arguments = [];

        $CommandCollection = new CommandCollection();

        // remove "avolute"
        array_shift($this->argv);

        // TODO if no command passed then show global help
        if(!isset($this->argv[0])) {
            $this->Console->header();
            $this->Console->writeLine('Usage:', ['color' => 'green']);
            $this->Console->writeLine('  command [arguments] [options]');
            $this->Console->writeLine('');
            $this->showAvailableCommands($CommandCollection);

            return 0;
        }

        // first remaining argument must be command name (no space allowed)
        $commandName = $this->argv[0];
        unset($this->argv[0]);

        // all values starting with - or -- are options
        // all other values are arguments
        array_filter($this->argv, function($value) use (&$options, &$arguments) {
            if(str_starts_with($value, '-') || str_starts_with($value, '--')) {
                $options[] = $value;
            } else {
                $arguments[] = $value;
            }
        });

        $command = $CommandCollection->getByName($commandName);
        // TODO check if no command found or -h was passed then show global help
        if($command == null) {
            $this->Console->writeLine('No valid command provided, choose one of the available commands.', 'error');
            $this->Console->writeLine('');
            $this->showAvailableCommands($CommandCollection);
            return 0;
        }

        $Command = new $command();
        // TODO check if arguments and options match with definition
        // if yes set passed arguments and options and execute command
        $Command->execute();
        // if no, show error and maybe the help text?

        /*print_r($arguments);
        print_r($options);
        printf($command);*/
    }

    /**
     * @param CommandCollection $CommandCollection
     */
    public function showAvailableCommands(CommandCollection $CommandCollection): void
    {
        $this->Console->writeLine('Available commands:', ['color' => 'green']);

        foreach ($CommandCollection->getAll() as $Command) {
            $this->Console->write('  ' . $Command::getName() . "\t", ['color' => 'yellow']);
            $this->Console->writeLine($Command::getDescription());
        }
    }
}