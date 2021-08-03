<?php


namespace Avolutions\Command;


use Avolutions\Core\Application;

class CreateControllerCommand extends Command
{
    protected static string $name = 'create-controller';
    protected static string $description = 'Creates a new Controller.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'Der Name des Controllers.'));
        $this->addOptionDefinition(new Option('log', 'l', 'Gibt an ob das Command geloggt werden soll.', true));
    }

    public function execute(): int
    {
        $inputArg = 'user';
        $forceMode = true;

        $controllerName = ucfirst($inputArg);
        $controllerFullname = $controllerName . 'Controller';
        $controllerFile = Application::getControllerPath() . $controllerFullname . '.php';

        // TODO force option
        if (file_exists($controllerFile) && !$forceMode) {
            $this->Console->writeLine($controllerFullname . '" already exists. If you want to override, please use force mode (-f).', 'error');
            return 0;
        }

        // TODO own class or own methods?
        $Template = new Template('controller');
        $Template->assign('namespace', rtrim(Application::getControllerNamespace(), '\\'));
        $Template->assign('controller', $controllerName);

        if($Template->save($controllerFile)) {
            $this->Console->writeLine('Controller created successfully.', 'success');
            return 1;
        } else {
            $this->Console->writeLine('Error when creating Controller.', 'error');
            return 0;
        }
    }
}