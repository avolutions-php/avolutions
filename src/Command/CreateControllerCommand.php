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
 * CreateControllerCommand class
 *
 * Creates a new Controller.
 *
 * @author  Alexander Vogt <alexander.vogt@avolutions.org>
 * @since   0.8.0
 */
class CreateControllerCommand extends AbstractCommand
{
    protected static string $name = 'create-controller';

    protected static string $description = 'Creates a new Controller.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Controller without "Controller" suffix.'));
        $this->addOptionDefinition(new Option('force', 'f', 'Controller will be overwritten if it already exists.'));
    }

    public function execute(): int
    {
        $controllerName = ucfirst($this->getArgument('name'));
        $controllerFullname = $controllerName . 'Controller';
        $controllerFile = $this->Application->getControllerPath() . $controllerFullname . '.php';

        if (file_exists($controllerFile) && !$this->getOption('force')) {
            $this->Console->writeLine(
                $controllerFullname . ' already exists. If you want to override, please use force mode (-f).',
                'error'
            );
            return ExitStatus::ERROR;
        }

        $Template = new Template('controller');
        $Template->assign('namespace', rtrim($this->Application->getControllerNamespace(), '\\'));
        $Template->assign('name', $controllerName);

        if ($Template->save($controllerFile)) {
            $this->Console->writeLine('Controller created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Controller.', 'error');
            return ExitStatus::ERROR;
        }
    }
}