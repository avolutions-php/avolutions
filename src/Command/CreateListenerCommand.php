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
    /**
     * @inheritdoc
     */
    protected static string $name = 'create-listener';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Creates a new Listener.';

    /**
     * @inheritDoc
     */
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
        $this->addOptionDefinition(new Option('event', 'e', 'TODO'));
        $this->addOptionDefinition(new Option('model', 'm', 'TODO'));
    }

    /**
     * @inheritDoc
     */
    public function execute(): int
    {
        $nameArgument = ucfirst($this->getArgument('name'));
        $listenerName = $nameArgument;
        // If generating a listener vor entity even (=model) do not add 'Event' to match naming conventions
        if(!$this->getOption('model')) {
            $listenerName = $listenerName . 'Event';
        }
        $listenerFullname = $listenerName . 'Listener';
        $listenerFile = Application::getListenerPath() . $listenerFullname . '.php';

        $force = $this->getOption('force');
        if (file_exists($listenerFile) && !$force) {
            $this->Console->writeLine($listenerFullname . ' already exists. If you want to override, please use force mode (-f).', 'error');
            return ExitStatus::ERROR;
        }

        if($this->getOption('event')) {
            $EventCommand = new CreateEventCommand();
            $parameters = [
                'name' => $nameArgument
            ];
            if ($force) {
                $parameters[] = '-f';
            }
            $EventCommand->start($parameters);
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