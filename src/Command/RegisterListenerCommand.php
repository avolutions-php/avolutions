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
 * RegisterListenerCommand class
 *
 * Register a new Listener for an Event in listener.php file.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class RegisterListenerCommand extends AbstractCommand
{
    protected static string $name = 'register-listener';

    protected static string $description = 'Registers a new Listener for an Event.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('event', 'The name of the Event class without "Event" suffix.'));
        $this->addArgumentDefinition(new Argument('listener', 'The name of the Listener class without "Listener" suffix. If none is given the name of the Event including "Event" suffix ist used.', true));
        $this->addArgumentDefinition(new Argument('method', 'The method of the Listener that should be called. Default value is "handleEvent".', true, 'handleEvent'));
        $this->addOptionDefinition(new Option('namespace', 'n', 'Register the Event with namespace.'));
    }

    public function execute(): int
    {
        $eventName = ucfirst($this->getArgument('event')) . 'Event';
        if ($this->getOption('namespace')) {
            $eventFullname = Application::getEventNamespace() . $eventName;
        } else {
            $eventFullname = $eventName;
        }

        if ($this->getArgument('listener') == null) {
            $listenerFullname = Application::getListenerNamespace() . $eventName . 'Listener';
        } else {
            $listenerFullname = Application::getListenerNamespace() . ucfirst($this->getArgument('listener')) . 'Listener';
        }

        $listenerFile = Application::getBasePath() . 'events.php';

        $Template = new Template('registerListener');
        $Template->assign('event', $eventFullname);
        $Template->assign('listener', $listenerFullname);
        $Template->assign('method', $this->getArgument('method'));

        if ($Template->save($listenerFile, true)) {
            $this->Console->writeLine('Listener registered successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when registering Listener.', 'error');
            return ExitStatus::ERROR;
        }
    }
}