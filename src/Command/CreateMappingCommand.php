<?php

namespace Avolutions\Command;

use Avolutions\Core\Application;

class CreateMappingCommand extends Command
{
    protected static string $name = 'create-mapping';
    protected static string $description = 'Creates a new Entity mapping file.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
    }

    public function execute(): int
    {
        $mappingName = ucfirst($this->getArgument('name'));
        $mappingFile = Application::getMappingPath() . $mappingName . 'Mapping.php';

        if (file_exists($mappingFile) && !$this->getOption('force')) {
            $this->Console->writeLine('Mapping "' . $mappingName . '" already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        $Template = new Template('mapping');
        $Template->assign('name', $mappingName);

        if($Template->save($mappingFile)) {
            $this->Console->writeLine('Mapping file created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating mapping file.', 'error');
            return 0;
        }
    }
}