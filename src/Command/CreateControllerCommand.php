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

use Avolutions\Core\Application;

/**
 * CreateControllerCommand class
 *
 * Creates a new Controller.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CreateControllerCommand extends AbstractCommand
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