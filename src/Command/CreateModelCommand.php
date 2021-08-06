<?php
/**
 * TODO
 */
namespace Avolutions\Command;

use Avolutions\Core\Application;
use DateTime;

/**
 * TODO
 */
class CreateModelCommand extends Command
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
            return 0;
        }

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
            $MigrationCommand = new CreateMigrationCommand();
            $parameters = [
                'name' => 'Create' . $modelName . 'Table',
                'version' => (new DateTime())->format('YmdHis')
            ];
            if ($force) {
                $parameters[] = '-f';
            }
            $MigrationCommand->start($parameters);
        }

        if($this->getOption('listener')) {
            $ListenerCommand = new CreateListenerCommand();
            $parameters = [
                'name' => $modelName,
                '-m'
            ];
            if ($force) {
                $parameters[] = '-f';
            }
            $ListenerCommand->start($parameters);
        }

        $Template = new Template('model');
        $Template->assign('namespace', rtrim(Application::getModelNamespace(), '\\'));
        $Template->assign('name', $modelName);

        if($Template->save($modelFile)) {
            $this->Console->writeLine('Model created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Model.', 'error');
            return 0;
        }
    }
}