<?php
/**
 * TODO
 */

namespace Avolutions\Command;

use Avolutions\Core\Application;

/**
 * TODO
 */
class CreateCommandCommand extends Command
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
            return 0;
        }

        $Template = new Template('command');
        $Template->assign('namespace', rtrim(Application::getCommandNamespace(), '\\'));
        $Template->assign('name', $commandName);
        $Template->assign('shortname', $shortname);

        if ($Template->save($commandFile)) {
            $this->Console->writeLine('Command created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Command.', 'error');
            return 0;
        }
    }
}