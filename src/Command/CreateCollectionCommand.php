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
 * CreateCollectionCommand class
 *
 * Creates a new EntityCollection.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.9.0
 */
class CreateCollectionCommand extends AbstractCommand
{
    protected static string $name = 'create-collection';

    protected static string $description = 'Creates a new EntityCollection.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Entity file without "Collection" suffix.'));
        $this->addOptionDefinition(
            new Option('force', 'f', 'EntityCollection will be overwritten if it already exists.')
        );
        $this->addOptionDefinition(new Option('model', 'm', 'Automatically creates a model for the EntityCollection.'));
    }

    public function execute(): int
    {
        $collectionName = ucfirst($this->getArgument('name'));
        $collectionFile = $this->Application->getModelPath() . $collectionName . 'Collection.php';

        $force = $this->getOption('force');
        if (file_exists($collectionFile) && !$force) {
            $this->Console->writeLine(
                'EntityCollection "' . $collectionFile . '" already exists. If you want to override, please use force mode (-f).',
                'error'
            );
            return ExitStatus::ERROR;
        }

        if ($this->getOption('model')) {
            $argv = 'create-model ' . $collectionName;
            if ($force) {
                $argv .= ' -f';
            }
            command($argv);
        }

        $Template = new Template('entityCollection');
        $Template->assign('namespace', rtrim($this->Application->getModelNamespace(), '\\'));
        $Template->assign('model', $collectionName);

        if ($Template->save($collectionFile)) {
            $this->Console->writeLine('EntityCollection created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating EntityCollection.', 'error');
            return ExitStatus::ERROR;
        }
    }
}