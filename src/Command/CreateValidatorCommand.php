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
 * CreateValidatorCommand class
 *
 * Creates a new Validator.
 *
 * @author	Alexander Vogt <alexander.vogt@avolutions.org>
 * @since	0.8.0
 */
class CreateValidatorCommand extends AbstractCommand
{
    protected static string $name = 'create-validator';

    protected static string $description = 'Creates a new Validator.';

    public function initialize(): void
    {
        $this->addArgumentDefinition(new Argument('name', 'The name of the Model class without "Validator" suffix.'));
        $this->addOptionDefinition(new Option('force', 'f', 'Validator will be overwritten if it already exists.'));
    }

    public function execute(): int
    {
        $validatorName = ucfirst($this->getArgument('name'));
        $validatorFullname = $validatorName . 'Validator';
        $validatorFile = Application::getValidatorPath() . $validatorFullname . '.php';

        if (file_exists($validatorFile) && !$this->getOption('force')) {
            $this->Console->writeLine($validatorFullname . ' already exists. If you want to override, please use force mode (-f).', 'error');
            return ExitStatus::ERROR;
        }

        $Template = new Template('validator');
        $Template->assign('namespace', rtrim(Application::getValidatorNamespace(), '\\'));
        $Template->assign('validator', $validatorName);

        if ($Template->save($validatorFile)) {
            $this->Console->writeLine('Validator created successfully.', 'success');
            return ExitStatus::SUCCESS;
        } else {
            $this->Console->writeLine('Error when creating Validator.', 'error');
            return ExitStatus::ERROR;
        }
    }
}