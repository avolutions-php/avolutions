<?php
/**
 * TODO
 */

namespace Avolutions\Command;

use Avolutions\Console\Console;
use Exception;

/**
 * TODO
 */
class CommandDispatcher
{
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
     * TODO
     *
     * @param array $argv TODO
     */
    public function __construct(array $argv)
    {
        $this->argv = $argv;
        $this->Console = new Console();
    }

    /**
     * TODO
     *
     * @return int TODO
     */
    public function start(): int
    {
        $CommandCollection = new CommandCollection();

        // remove "avolute"
        array_shift($this->argv);

        if (!isset($this->argv[0])) {
            $this->Console->header();
            $this->Console->writeLine('Usage:', ['color' => 'green']);
            $this->Console->writeLine('  command [arguments] [options]');
            $this->Console->writeLine('');
            $this->showAvailableCommands($CommandCollection);

            // TODO replace by const
            return 0;
        }

        // first remaining argument must be command name (no space allowed)
        $commandName = $this->argv[0];
        unset($this->argv[0]);

        $command = $CommandCollection->getByName($commandName);
        if ($command == null) {
            $this->Console->writeLine('No valid command provided, choose one of the available commands.', 'error');
            $this->Console->writeLine('');
            $this->showAvailableCommands($CommandCollection);
            return 0;
        }

        try {
            $Command = new $command($this->Console);
            return $Command->start($this->argv);
        } catch (Exception $exception) {
            $this->Console->writeLine($exception->getMessage(), 'error');
            return 0;
        }
    }

    /**
     * TODO
     *
     * @param CommandCollection $CommandCollection TODO
     */
    public function showAvailableCommands(CommandCollection $CommandCollection): void
    {
        $Commands = $CommandCollection->getAll();

        $longestCommandSize = max(array_map('strlen', array_keys($Commands)));

        $this->Console->writeLine('Available commands:', ['color' => 'green']);

        foreach ($CommandCollection->getAll() as $Command) {
            $this->Console->write('  ' . str_pad($Command::getName(), $longestCommandSize) . "\t", ['color' => 'yellow']);
            $this->Console->writeLine($Command::getDescription());
        }
    }
}