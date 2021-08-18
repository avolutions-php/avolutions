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

use Avolutions\Collection\CollectionInterface;
use Avolutions\Collection\CollectionTrait;
use Avolutions\Core\Application;

use FilesystemIterator;
use ReflectionException;
use RegexIterator;

/**
 * CommandCollection class
 *
 * The CommandCollection contains all Commands from core and app.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CommandCollection implements CollectionInterface
{
    use CollectionTrait;

    /**
     * __construct
     *
     * Creates a new CommandCollection instance with all Commands added.
     */
    public function __construct()
    {
        $coreCommands = $this->searchCommands(__DIR__, 'Avolutions\\Command\\');
        $appCommands =  $this->searchCommands(Application::getCommandPath(), Application::getCommandNamespace());

        $this->items = array_unique(array_merge($coreCommands, $appCommands));
    }

    /**
     * getByName
     *
     * Returns an Command by its name.
     *
     * @param string $commandName The command name.
     *
     * @return string|null An Command Object or null if none found.
     */
    public function getByName(string $commandName): ?string
    {
        return $this->items[strtolower($commandName)] ?? null;
    }

    /**
     * searchCommands
     *
     * Search Commands in the given path.
     *
     * @param string $directory The path to search commands in.
     * @param string $namespace The namespace of the commands in the given path.
     *
     * @return array An array containing all commands found in path and namespace.
     *
     * @throws ReflectionException
     */
    private function searchCommands(string $directory, string $namespace): array
    {
        $commands = [];

        if (is_dir($directory)) {
            $files = new RegexIterator(new FilesystemIterator($directory), '/Command.php/');

            foreach ($files as $file) {
                $class = $namespace . pathinfo($file, PATHINFO_FILENAME);
                if (is_subclass_of($class, AbstractCommand::class)) {
                    $commands[strtolower($class::getName())] = $class;
                }
            }
        }

        return $commands;
    }
}