<?php

namespace Avolutions\Command;

use Avolutions\Core\Application;

class CreateModelCommand extends Command
{
    protected static string $name = 'create-model';
    protected static string $description = 'Creates a new Entity model.';

    public function initialize(): void
    {
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
    }

    public function execute(): int
    {
        $inputArg = 'user';

        $modelName = ucfirst($inputArg);
        $modelFile = Application::getModelPath() . $modelName . '.php';

        // TODO force option
        if (file_exists($modelFile) && !$this->getOption('force')) {
            $this->Console->writeLine('Model "' . $modelName . '" already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        // TODO own class or own methods?
        $Template = new Template('model');
        $Template->assign('namespace', rtrim(Application::getModelNamespace(), '\\'));
        $Template->assign('model', $modelName);

        if($Template->save($modelFile)) {
            $this->Console->writeLine('Model created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Model.', 'error');
            return 0;
        }
    }
}