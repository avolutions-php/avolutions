<?php
/*
 * TODO
 */

namespace Avolutions\Command;

use Avolutions\Collection\CollectionInterface;
use Avolutions\Collection\CollectionTrait;
use Avolutions\Core\Application;

use FilesystemIterator;
use RegexIterator;

/*
 * TODO
 */
class CommandCollection implements CollectionInterface
{
    use CollectionTrait;

    /**
     * TODO
     */
    public function __construct()
    {
        $coreCommands =  $this->searchCommands(__DIR__, 'Avolutions\\Command\\');
        $appCommands =  $this->searchCommands(Application::getCommandPath(), Application::getCommandNamespace());

        $this->items = array_unique(array_merge($coreCommands, $appCommands));
    }

    /**
     * TODO
     *
     * @param string $directory TODO
     * @param string $namespace TODO
     *
     * @return array TODO
     */
    public function searchCommands(string $directory, string $namespace): array
    {
        $commands = [];

        $files = new RegexIterator(new FilesystemIterator($directory), '/Command.php/');

        foreach ($files as $file) {
            $class = $namespace.pathinfo($file, PATHINFO_FILENAME);
            if (is_subclass_of($class, Command::class)) {
                $commands[strtolower($class::getName())] = $class;
            }
        }

        return $commands;
    }

    /**
     * TODO
     *
     * @param string $commandName TODO
     *
     * @return string|null TODO
     */
    public function getByName(string $commandName): ?string
    {
        return $this->items[strtolower($commandName)] ?? null;
    }
}