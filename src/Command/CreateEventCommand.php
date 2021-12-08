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
 * CreateEventCommand class
 *
 * Creates a new Event.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class CreateEventCommand extends AbstractCommand
{
    protected static string $name = 'create-event';

    protected static string $description = 'Creates a new Event.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Event class without "Event" suffix.'));
        $this->addArgumentDefinition(new Argument('shortname', 'The name to dispatch the Event with.', true));
        $this->addOptionDefinition(new Option('force', 'f', 'Event will be overwritten if it already exists.'));
        $this->addOptionDefinition(new Option('listener', 'l', 'Automatically creates a Listener for the Event.'));
        $this->addOptionDefinition(
            new Option(
                'register',
                'r',
                'Automatically register a Listener for the Event. Only works if Option "listener" is set.'
            )
        );
    }

    public function execute(): int
    {
        $eventName = ucfirst($this->getArgument('name'));
        $eventFullname = $eventName . 'Event';
        $shortname = $this->getArgument('shortname');
        $eventFile = $this->Application->getEventPath() . $eventFullname . '.php';

        $force = $this->getOption('force');
        if (file_exists($eventFile) && !$force) {
            $this->Console->writeLine(
                $eventFullname . ' already exists. If you want to override, please use force mode (-f).',
                'error'
            );
            return ExitStatus::ERROR;
        }

        if ($this->getOption('listener')) {
            $argv = 'create-listener ' . $eventName;
            if ($force) {
                $argv .= ' -f';
            }
            command($argv);

            if ($this->getOption('register')) {
                $argv = 'register-listener ' . $eventName . ' ' . $eventFullname;
                if (!$shortname) {
                    $argv .= ' -n';
                }
                command($argv);
            }
        }

        $shortnameCode = $shortname != null ? 'protected string $name = \'' . $shortname . '\';' : '';

        $Template = new Template('event');
        $Template->assign('namespace', rtrim($this->Application->getEventNamespace(), '\\'));
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