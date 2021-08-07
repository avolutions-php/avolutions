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
use DateTime;

/**
 * CreateModelCommand class
 *
 * Creates a new Entity model.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CreateModelCommand extends AbstractCommand
{
    /**
     * @inheritdoc
     */
    protected static string $name = 'create-model';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Creates a new Entity model.';

    /**
     * @inheritdoc
     */
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
        $this->addOptionDefinition(new Option('mapping', '', 'TODO', false));
        $this->addOptionDefinition(new Option('migration', '', 'TODO', false));
        $this->addOptionDefinition(new Option('listener', '', 'TODO', false));
    }

    /**
     * @inheritdoc
     */
    public function execute(): int
    {
        $modelName = ucfirst($this->getArgument('name'));
        $modelFile = Application::getModelPath() . $modelName . '.php';

        $force = $this->getOption('force');
        if (file_exists($modelFile) && !$force) {
            $this->Console->writeLine('Model "' . $modelName . '" already exists. If you want to override, please use force mode (-f).', 'error');
            return ExitStatus::ERROR;
        }

        $Commander = new CommandDispatcher();
        if ($this->getOption('mapping')) {
            $argv = 'create-mapping ' . $modelName;
            if ($force) {
                $argv .= ' -f' ;
            }
            $Commander->dispatch($argv);
        }

        if ($this->getOption('migration')) {
            $argv = 'create-migration ' . 'Create' . $modelName . 'Table ' . (new DateTime())->format('YmdHis');
            if ($force) {
                $argv .= ' -f' ;
            }
            $Commander->dispatch($argv);
        }

        if ($this->getOption('listener')) {
            $argv = 'create-listener ' . $modelName . ' -m';
            if ($force) {
                $argv .= ' -f' ;
            }
            $Commander->dispatch($argv);
        }

        $Template = new Template('model');
        $Template->assign('namespace', rtrim(Application::getModelNamespace(), '\\'));
        $Template->assign('name', $modelName);

        if($Template->save($modelFile)) {
            $this->Console->writeLine('Model created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Model.', 'error');
            return ExitStatus::ERROR;
        }
    }
}