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
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
        $this->addOptionDefinition(new Option('listener', 'l', 'TODO'));
    }

    /**
     * @inheritDoc
     */
    public function execute(): int
    {
        $eventName = ucfirst($this->getArgument('name'));
        $eventFullname = $eventName . 'Event';
        $eventFile = Application::getEventPath() . $eventFullname . '.php';

        $force = $this->getOption('force');
        if (file_exists($eventFile) && !$force) {
            $this->Console->writeLine($eventFullname . ' already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        if ($this->getOption('listener')) {
            $ListenerCommand = new CreateListenerCommand();
            $parameters = [
                'name' => $eventName
            ];
            if ($force) {
                $parameters[] = '-f';
            }
            $ListenerCommand->start($parameters);
        }

        $Template = new Template('event');
        $Template->assign('namespace', rtrim(Application::getEventNamespace(), '\\'));
        $Template->assign('name', $eventName);

        if ($Template->save($eventFile)) {
            $this->Console->writeLine('Event created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Event.', 'error');
            return 0;
        }
    }
}