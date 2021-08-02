<?php


namespace Avolutions\Command;


class CreateControllerCommand extends Command
{
    protected static string $description = 'Creates a new Controller.';

    public static function getName(): string
    {
        return 'create:controller';
    }

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'Der Name des Controllers.'));
        $this->addOptionDefinition(new Option('log', 'l', 'Gibt an ob das Command geloggt werden soll.', true));
    }

    public function execute()
    {
        printf("\e[1;34mCreate Controller!\e[0m");
    }
}