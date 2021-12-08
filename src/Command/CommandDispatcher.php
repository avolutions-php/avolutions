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
use Avolutions\Core\Application;
use InvalidArgumentException;
use Throwable;

/**
 * CommandDispatcher class
 *
 * Find and run commands based on passed arguments.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class CommandDispatcher
{
    /**
     * Application instance.
     *
     * @var Application $Application
     */
    private Application $Application;

    /**
     * CommandCollection instance.
     *
     * @var CommandCollection $Application
     */
    private CommandCollection $CommandCollection;

    /**
     * Console instance for output.
     *
     * @var Console $Console
     */
    private Console $Console;

    /**
     * __construct
     *
     * Creates a new CommandDispatcher instance.
     *
     * @param Application $Application Application instance.
     * @param CommandCollection $CommandCollection CommandCollection instance.
     * @param Console $Console Console instance for output.
     */
    public function __construct(Application $Application, CommandCollection $CommandCollection, Console $Console)
    {
        $this->Application = $Application;
        $this->CommandCollection = $CommandCollection;
        $this->Console = $Console;
    }


    /**
     * dispatch
     *
     * Find and run command based on passed arguments.
     *
     * @param mixed $argv Command string or array with arguments and Options.
     *
     * @return int Exit status.
     */
    public function dispatch(mixed $argv): int
    {
        if (!is_array($argv) && !is_string($argv)) {
            throw new InvalidArgumentException('$argv must be either of type array or type string.');
        }

        if (is_string($argv)) {
            $argv = explode(' ', $argv);
        }

        if (!isset($argv[0])) {
            $this->Console->writeLine(
                file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'avolutions.txt')
            );
            $this->Console->writeLine('Usage:', ['color' => 'green']);
            $this->Console->writeLine('  command [arguments] [options]');
            $this->Console->writeLine('');
            $this->showAvailableCommands($this->CommandCollection);

            return ExitStatus::ERROR;
        }

        // first remaining argument must be command name (no space allowed)
        $commandName = $argv[0];
        unset($argv[0]);

        $command = $this->CommandCollection->getByName($commandName);
        if ($command == null) {
            $this->Console->writeLine('No valid command provided, choose one of the available commands.', 'error');
            $this->Console->writeLine('');
            $this->showAvailableCommands($this->CommandCollection);

            return ExitStatus::ERROR;
        }

        try {
            $Command = $this->Application->get($command);
            return $Command->start($argv);
        } catch (Throwable $exception) {
            $this->Console->writeLine($exception->getMessage(), 'error');
            return ExitStatus::ERROR;
        }
    }

    /**
     * showAvailableCommands
     *
     * Displays all available commands from CommandCollection.
     *
     * @param CommandCollection $CommandCollection CommandCollection with all available commands.
     */
    private function showAvailableCommands(CommandCollection $CommandCollection): void
    {
        $Commands = $CommandCollection->getAll();

        $longestCommandSize = max(array_map('strlen', array_keys($Commands)));

        $this->Console->writeLine('Available commands:', ['color' => 'green']);

        foreach ($CommandCollection->getAll() as $Command) {
            $this->Console->write(
                '  ' . str_pad($Command::getName(), $longestCommandSize) . "\t",
                ['color' => 'yellow']
            );
            $this->Console->writeLine($Command::getDescription());
        }
    }
}