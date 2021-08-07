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

use Avolutions\Core\Application;

/**
 * CreateCommandCommand class
 *
 * Creates an new Command.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CreateCommandCommand extends AbstractCommand
{
    /**
     * @inheritdoc
     */
    protected static string $name = 'create-command';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Creates a new Command.';

    /**
     * @inheritdoc
     */
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addArgumentDefinition(new Argument('shortname', 'TODO', true));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
    }

    /**
     * @inheritdoc
     */
    public function execute(): int
    {
        $commandName = ucfirst($this->getArgument('name'));
        $shortname = $this->getArgument('shortname') ?? '';
        $commandFullname = $commandName . 'Command';
        $commandFile = Application::getCommandPath() . $commandFullname . '.php';

        if (file_exists($commandFile) && !$this->getOption('force')) {
            $this->Console->writeLine($commandFullname . ' already exists. If you want to override, please use force mode (-f).', 'error');
            return ExitStatus::ERROR;
        }

        $Template = new Template('command');
        $Template->assign('namespace', rtrim(Application::getCommandNamespace(), '\\'));
        $Template->assign('name', $commandName);
        $Template->assign('shortname', $shortname);

        if ($Template->save($commandFile)) {
            $this->Console->writeLine('Command created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Command.', 'error');
            return ExitStatus::ERROR;
        }
    }
}