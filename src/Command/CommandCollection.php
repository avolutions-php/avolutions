<?php


namespace Avolutions\Command;

use Avolutions\Collection\CollectionInterface;
use Avolutions\Collection\CollectionTrait;

use FilesystemIterator;
use RegexIterator;
use const Avolutions\APP_COMMAND_NAMESPACE;
use const Avolutions\APP_COMMAND_PATH;
use const Avolutions\APP_DATABASE_PATH;
use const Avolutions\COMMAND;
use const Avolutions\COMMAND_NAMESPACE;

class CommandCollection implements CollectionInterface
{
    use CollectionTrait;

    /**
     * TODO
     */
    public function __construct()
    {
        $coreCommands =  $this->searchCommands(__DIR__, COMMAND_NAMESPACE);
        // TODO fix Application Path ($_SERVER not working in cli) or best all constants defined in bootstrap
        //$appCommands =  $this->searchCommands(APP_COMMAND_PATH, APP_COMMAND_NAMESPACE);
        $appCommands = [];

        $this->items = array_unique(array_merge($coreCommands, $appCommands));
    }

    /**
     * TODO
     *
     * @param string $directory
     * @param string $namespace
     *
     * @return array
     */
    public function searchCommands(string $directory, string $namespace): array
    {
        $commands = [];

        $files = new RegexIterator(new FilesystemIterator($directory), '/'.COMMAND.'.php/');

        foreach ($files as $file) {
            $class = $namespace.pathinfo($file, PATHINFO_FILENAME);
            if (is_subclass_of($class, Command::class)) {
                $commands[$class::getName()] = $class;
            }
        }

        return $commands;
    }

    public function getByName(string $commandName): string
    {
        return $this->items[$commandName];
    }
}