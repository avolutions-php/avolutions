<?php
/**
 * TODO
 */

namespace Avolutions\Command;

use Avolutions\Core\Application;

/**
 * TODO
 */
class CreateControllerCommand extends Command
{
    /**
     * @inheritdoc
     */
    protected static string $name = 'create-controller';

    /**
     * @inheritdoc
     */
    protected static string $description = 'Creates a new Controller.';

    /**
     * @inheritdoc
     */
    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'TODO'));
        $this->addOptionDefinition(new Option('force', 'f', 'TODO'));
    }

    /**
     * @inheritdoc
     */
    public function execute(): int
    {
        $controllerName = ucfirst($this->getArgument('name'));
        $controllerFullname = $controllerName . 'Controller';
        $controllerFile = Application::getControllerPath() . $controllerFullname . '.php';

        if (file_exists($controllerFile) && !$this->getOption('force')) {
            $this->Console->writeLine($controllerFullname . ' already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        $Template = new Template('controller');
        $Template->assign('namespace', rtrim(Application::getControllerNamespace(), '\\'));
        $Template->assign('name', $controllerName);

        if ($Template->save($controllerFile)) {
            $this->Console->writeLine('Controller created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Controller.', 'error');
            return 0;
        }
    }
}