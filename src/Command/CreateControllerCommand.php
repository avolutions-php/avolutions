<?php


namespace Avolutions\Command;


class CreateControllerCommand extends Command
{
    public function getName(): string
    {
        return 'create:controller';
    }

    public function initialize(): void
    {
        $this->addArgument(new Argument('name', 'Der Name des Controllers.'));
        $this->addOption(new Option('log', 'l', 'Gibt an ob das Command geloggt werden soll.', true));
    }

    public function execute()
    {
        //printf("\e[1;34mMerry Christmas!\e[0m");
    }
}