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
 * CreateMappingCommand class
 *
 * Creates a new Entity mapping file.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class CreateMappingCommand extends AbstractCommand
{
    protected static string $name = 'create-mapping';

    protected static string $description = 'Creates a new Entity mapping file.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the mapping file without "Mapping" suffix.'));
        $this->addOptionDefinition(new Option('force', 'f', 'Mapping file will be overwritten if it already exists.'));
        $this->addOptionDefinition(new Option('model', 'm', 'Automatically creates a model for the mapping.'));
    }

    public function execute(): int
    {
        $mappingName = ucfirst($this->getArgument('name'));
        $mappingFile = $this->Application->getMappingPath() . $mappingName . 'Mapping.php';

        $force = $this->getOption('force');
        if (file_exists($mappingFile) && !$force) {
            $this->Console->writeLine(
                'Mapping file "' . $mappingName . '" already exists. If you want to override, please use force mode (-f).',
                'error'
            );
            return ExitStatus::ERROR;
        }

        if ($this->getOption('model')) {
            $argv = 'create-model ' . $mappingName;
            if ($force) {
                $argv .= ' -f';
            }
            command($argv);
        }

        $Template = new Template('mapping');
        $Template->assign('name', $mappingName);

        if ($Template->save($mappingFile)) {
            $this->Console->writeLine('Mapping file created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating mapping file.', 'error');
            return ExitStatus::ERROR;
        }
    }
}