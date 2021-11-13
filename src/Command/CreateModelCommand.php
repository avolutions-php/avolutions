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
 * CreateModelCommand class
 *
 * Creates a new Entity model.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class CreateModelCommand extends AbstractCommand
{
    protected static string $name = 'create-model';

    protected static string $description = 'Creates a new Entity model.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Model class.'));
        $this->addOptionDefinition(new Option('force', 'f', 'Model will be overwritten if it already exists.'));
        $this->addOptionDefinition(
            new Option('mapping', 'm', 'Automatically creates a mapping file for the Model.', false)
        );
        $this->addOptionDefinition(
            new Option('migration', 'd', 'Automatically creates a Migration for the Model.', false)
        );
        $this->addOptionDefinition(
            new Option('listener', 'l', 'Automatically creates a Listener for the Model.', false)
        );
    }

    public function execute(): int
    {
        $modelName = ucfirst($this->getArgument('name'));
        $modelFile = $this->Application->getModelPath() . $modelName . '.php';

        $force = $this->getOption('force');
        if (file_exists($modelFile) && !$force) {
            $this->Console->writeLine(
                'Model "' . $modelName . '" already exists. If you want to override, please use force mode (-f).',
                'error'
            );
            return ExitStatus::ERROR;
        }

        if ($this->getOption('mapping')) {
            $argv = 'create-mapping ' . $modelName;
            if ($force) {
                $argv .= ' -f';
            }
            command($argv);
        }

        if ($this->getOption('migration')) {
            $argv = 'create-migration ' . 'Create' . $modelName . 'Table ';
            if ($force) {
                $argv .= ' -f';
            }
            command($argv);
        }

        if ($this->getOption('listener')) {
            $argv = 'create-listener ' . $modelName . ' -m';
            if ($force) {
                $argv .= ' -f';
            }
            command($argv);
        }

        $Template = new Template('model');
        $Template->assign('namespace', rtrim($this->Application->getModelNamespace(), '\\'));
        $Template->assign('name', $modelName);

        if ($Template->save($modelFile)) {
            $this->Console->writeLine('Model created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Model.', 'error');
            return ExitStatus::ERROR;
        }
    }
}