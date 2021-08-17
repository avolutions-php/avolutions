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
 * CreateListenerCommand class
 *
 * Creates a new Listener.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CreateListenerCommand extends AbstractCommand
{
    protected static string $name = 'create-listener';

    protected static string $description = 'Creates a new Listener.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Listener class without "Listener" suffix.'));
        $this->addOptionDefinition(new Option('force', 'f', 'Listener will be overwritten if it already exists.'));
        $this->addOptionDefinition(new Option('event', 'e', 'Automatically creates an Event for the Listener.'));
        $this->addOptionDefinition(new Option('model', 'm', 'Indicates if Listener is for EntityEvent to use correct naming conventions.'));
        $this->addOptionDefinition(new Option('register', 'r', 'Automatically register an Event for the Listener. Only works if Option "event" is set. Not needed if option "model" is set.'));
    }

    public function execute(): int
    {
        $nameArgument = ucfirst($this->getArgument('name'));
        $listenerName = $nameArgument;
        // If generating a listener for entity event (=model) do not add 'Event' to match naming conventions
        if (!$this->getOption('model')) {
            $listenerName = $listenerName . 'Event';
        }
        $listenerFullname = $listenerName . 'Listener';
        $listenerFile = Application::getListenerPath() . $listenerFullname . '.php';

        $force = $this->getOption('force');
        if (file_exists($listenerFile) && !$force) {
            $this->Console->writeLine($listenerFullname . ' already exists. If you want to override, please use force mode (-f).', 'error');
            return ExitStatus::ERROR;
        }

        if ($this->getOption('event')) {
            $argv = 'create-event ' . $nameArgument;
            if ($force) {
                $argv .= ' -f' ;
            }
            command($argv);

            if ($this->getOption('register') && !$this->getOption('model')) {
                $argv = 'register-listener ' . $nameArgument . ' ' . $nameArgument . ' -n';
                command($argv);
            }
        }

        $Template = new Template('listener');
        $Template->assign('namespace', rtrim(Application::getEventNamespace(), '\\'));
        $Template->assign('name', $listenerName);

        if ($Template->save($listenerFile)) {
            $this->Console->writeLine('Listener created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Listener.', 'error');
            return ExitStatus::ERROR;
        }
    }
}