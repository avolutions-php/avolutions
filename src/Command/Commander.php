<?php


namespace Avolutions\Command;


class Commander
{
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
    }

    /**
     * TODO
     */
    public function start()
    {
        $options = [];
        $arguments = [];

        // remove "avolute"
        array_shift($this->argv);

        // first remaining argument must be command name (no space allowed)
        // TODO if no command passed then show global help
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

        $CommandCollection = new CommandCollection();
        $command = $CommandCollection->getByName($commandName);
        // TODO check if no command found or -h was passed then show global help

        $Command = new $command();
        // TODO check if arguments and options match with definition
        // if yes set passed arguments and options and execute command
        $Command->execute();
        // if no, show error and maybe the help text?

        print_r($arguments);
        print_r($options);
        printf($command);
    }
}