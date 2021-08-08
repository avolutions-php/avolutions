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
 * CreateEventCommand class
 *
 * Creates a new Event.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CreateEventCommand extends AbstractCommand
{
    /**
     * @inheritdoc
     */
    protected static string $name = 'create-event';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Creates a new Event.';

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Event class without "Event" suffix.'));
        $this->addArgumentDefinition(new Argument('shortname', 'The name to dispatch the Event with.', true));
        $this->addOptionDefinition(new Option('force', 'f', 'Event will be overwritten if it already exists.'));
        $this->addOptionDefinition(new Option('listener', 'l', 'Automatically creates a Listener for the Event.'));
        $this->addOptionDefinition(new Option('register', 'r', 'Automatically register a Listener for the Event. Only works if Option "listener" is set.'));
    }

    /**
     * @inheritDoc
     */
    public function execute(): int
    {
        $eventName = ucfirst($this->getArgument('name'));
        $eventFullname = $eventName . 'Event';
        $shortname = $this->getArgument('shortname');
        $eventFile = Application::getEventPath() . $eventFullname . '.php';

        $force = $this->getOption('force');
        if (file_exists($eventFile) && !$force) {
            $this->Console->writeLine($eventFullname . ' already exists. If you want to override, please use force mode (-f).', 'error');
            return ExitStatus::ERROR;
        }

        if ($this->getOption('listener')) {
            $Commander = new CommandDispatcher();
            $argv = 'create-listener ' . $eventName;
            if ($force) {
                $argv .= ' -f' ;
            }
            $Commander->dispatch($argv);

            if ($this->getOption('register')) {
                $argv = 'register-listener ' . $eventName . ' ' . $eventFullname;
                $argv .= $shortname ? '' : '-n';
                $Commander->dispatch($argv);
            }
        }

        $shortnameCode = $shortname != null ? 'protected string $name = \'' . $shortname . '\';': '';

        $Template = new Template('event');
        $Template->assign('namespace', rtrim(Application::getEventNamespace(), '\\'));
        $Template->assign('name', $eventName);
        $Template->assign('shortname', $shortnameCode);

        if ($Template->save($eventFile)) {
            $this->Console->writeLine('Event created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Event.', 'error');
            return ExitStatus::ERROR;
        }
    }
}