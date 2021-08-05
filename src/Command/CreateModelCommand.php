<?php

namespace Avolutions\Command;

use Avolutions\Core\Application;
use DateTime;

class CreateModelCommand extends Command
{
    protected static string $name = 'create-model';
    protected static string $description = 'Creates a new Entity model.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
        $this->addOptionDefinition(new Option('mapping', '', 'TODO', false));
        $this->addOptionDefinition(new Option('migration', '', 'TODO', false));
    }

    public function execute(): int
    {
        $modelName = ucfirst($this->getArgument('name'));
        $modelFile = Application::getModelPath() . $modelName . '.php';

        $force = $this->getOption('force');
        if (file_exists($modelFile) && !$force) {
            $this->Console->writeLine('Model "' . $modelName . '" already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        $Template = new Template('model');
        $Template->assign('namespace', rtrim(Application::getModelNamespace(), '\\'));
        $Template->assign('model', $modelName);

        if($this->getOption('mapping')) {
            $MappingCommand = new CreateMappingCommand();
            $parameters = [
                'name' => $modelName
            ];
            if ($force) {
                $parameters[] = '-f';
            }
            $MappingCommand->start($parameters);
        }

        if($this->getOption('migration')) {
            $MappingCommand = new CreateMigrationCommand();
            $parameters = [
                'name' => 'Create' . $modelName . 'Table',
                'version' => (new DateTime())->format('YmdHis')
            ];
            if ($force) {
                $parameters[] = '-f';
            }
            $MappingCommand->start($parameters);
        }

        if($Template->save($modelFile)) {
            $this->Console->writeLine('Model created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Model.', 'error');
            return 0;
        }
    }
}