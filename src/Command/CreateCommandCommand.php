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

/**
 * CreateCommandCommand class
 *
 * Creates a new Command.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class CreateCommandCommand extends AbstractCommand
{
    protected static string $name = 'create-command';

    protected static string $description = 'Creates a new Command.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Command class without "Command" suffix.'));
        $this->addArgumentDefinition(new Argument('shortname', 'The name to execute the command with.', true, ''));
        $this->addOptionDefinition(new Option('force', 'f', 'Command will be overwritten if it already exists.'));
    }

    public function execute(): int
    {
        $commandName = ucfirst($this->getArgument('name'));
        $commandFullname = $commandName . 'Command';
        $commandFile = $this->Application->getCommandPath() . $commandFullname . '.php';

        if (file_exists($commandFile) && !$this->getOption('force')) {
            $this->Console->writeLine(
                $commandFullname . ' already exists. If you want to override, please use force mode (-f).',
                'error'
            );
            return ExitStatus::ERROR;
        }

        $Template = new Template('command');
        $Template->assign('namespace', rtrim($this->Application->getCommandNamespace(), '\\'));
        $Template->assign('name', $commandName);
        $Template->assign('shortname', $this->getArgument('shortname'));

        if ($Template->save($commandFile)) {
            $this->Console->writeLine('Command created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Command.', 'error');
            return ExitStatus::ERROR;
        }
    }
}